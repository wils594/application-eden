
import 'dart:async';

import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';

import '../../services/api_service.dart';

class ChatScreen extends StatefulWidget {
  const ChatScreen({super.key});

  @override
  State<ChatScreen> createState() => _ChatScreenState();
}

class _ChatScreenState extends State<ChatScreen> {
  static const Color primary = Color(0xFF2563EB);
  static const Color primaryDark = Color(0xFF1D4ED8);
  static const Color textDark = Color(0xFF111827);
  static const Color textMuted = Color(0xFF6B7280);
  static const Color background = Color(0xFFF7F9FC);
  static const Color border = Color(0xFFE5E7EB);
  static const Color primarySoft = Color(0xFFEFF6FF);

  final TextEditingController _messageController =
      TextEditingController();

  final ScrollController _scrollController = ScrollController();

  List<Map<String, dynamic>> _messages = [];

  bool _loading = true;
  bool _sending = false;
  bool _isRefreshing = false;

  String? _error;

  Timer? _refreshTimer;

  @override
  void initState() {
    super.initState();

    _loadMessages();

    // Vérifie automatiquement les nouveaux messages.
    _refreshTimer = Timer.periodic(
      const Duration(seconds: 4),
      (_) {
        if (mounted && !_loading && !_sending && !_isRefreshing) {
          _loadMessages(showLoading: false);
        }
      },
    );
  }

  @override
  void dispose() {
    _refreshTimer?.cancel();
    _messageController.dispose();
    _scrollController.dispose();
    super.dispose();
  }

  Future<void> _loadMessages({
    bool showLoading = true,
  }) async {
    if (_isRefreshing) return;

    _isRefreshing = true;

    if (mounted) {
      setState(() {
        if (showLoading) {
          _loading = true;
        }
        _error = null;
      });
    }

    try {
      final result = await ApiService.get('/chat');
      final rawMessages = result['messages'];

      final messages = rawMessages is List
          ? rawMessages
              .whereType<Map>()
              .map(
                (message) => Map<String, dynamic>.from(message),
              )
              .toList()
          : <Map<String, dynamic>>[];

      if (!mounted) return;

      setState(() {
        _messages = messages;
        _loading = false;
      });

      _scrollToBottom();
    } catch (e) {
      if (!mounted) return;

      setState(() {
        _loading = false;
        _error = e.toString().replaceFirst('Exception: ', '');
      });
    } finally {
      _isRefreshing = false;
    }
  }

  Future<void> _sendMessage() async {
    final body = _messageController.text.trim();

    if (body.isEmpty || _sending) return;

    // Identifiant temporaire pour retrouver le message en cas d'erreur.
    final temporaryId = Object();

    final temporaryMessage = <String, dynamic>{
      '_temporaryId': temporaryId,
      'body': body,
      'created_at': DateTime.now().toIso8601String(),
      'sender': {
        'role': 'parent',
        'name': 'Vous',
      },
    };

    setState(() {
      _sending = true;
      _error = null;
      _messages.add(temporaryMessage);
    });

    _messageController.clear();
    _scrollToBottom();

    try {
      // Enregistre le message sur Laravel.
      await ApiService.postAuthenticated('/chat', {
        'body': body,
      });

      if (!mounted) return;

      // Récupère les messages officiels du serveur.
      await _loadMessages(showLoading: false);
    } catch (e) {
      if (!mounted) return;

      setState(() {
        _messages.removeWhere(
          (message) => message['_temporaryId'] == temporaryId,
        );

        _error = e.toString().replaceFirst('Exception: ', '');
      });

      // Restaure le texte pour permettre une nouvelle tentative.
      _messageController.text = body;
    } finally {
      if (mounted) {
        setState(() {
          _sending = false;
        });
      }
    }
  }

  void _scrollToBottom() {
    WidgetsBinding.instance.addPostFrameCallback((_) {
      if (_scrollController.hasClients) {
        _scrollController.animateTo(
          _scrollController.position.maxScrollExtent,
          duration: const Duration(milliseconds: 250),
          curve: Curves.easeOut,
        );
      }
    });
  }

  Widget _svg({
    required String asset,
    Color color = textDark,
    double size = 22,
  }) {
    return SvgPicture.asset(
      asset,
      width: size,
      height: size,
      colorFilter: ColorFilter.mode(
        color,
        BlendMode.srcIn,
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: background,
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0,
        scrolledUnderElevation: 0,
        centerTitle: false,
        titleSpacing: 20,
        title: Row(
          children: [
            Container(
              width: 42,
              height: 42,
              padding: const EdgeInsets.all(10),
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [primary, primaryDark],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),
                borderRadius: BorderRadius.circular(12),
                boxShadow: [
                  BoxShadow(
                    color: primary.withOpacity(0.25),
                    blurRadius: 10,
                    offset: const Offset(0, 4),
                  ),
                ],
              ),
              child: _svg(
                asset: 'assets/icons/chat.svg',
                color: Colors.white,
              ),
            ),
            const SizedBox(width: 12),
            const Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Messages',
                    style: TextStyle(
                      color: textDark,
                      fontSize: 17,
                      fontWeight: FontWeight.bold,
                      letterSpacing: -0.3,
                    ),
                  ),
                  SizedBox(height: 2),
                  Text(
                    'Échangez avec l’administration',
                    style: TextStyle(
                      color: textMuted,
                      fontSize: 11,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                ],
              ),
            ),
            IconButton(
              tooltip: 'Actualiser',
              onPressed: _loading || _isRefreshing
                  ? null
                  : () => _loadMessages(),
              icon: _loading || _isRefreshing
                  ? const SizedBox(
                      width: 20,
                      height: 20,
                      child: CircularProgressIndicator(
                        strokeWidth: 2.2,
                        color: primary,
                      ),
                    )
                  : _svg(
                      asset: 'assets/icons/refresh.svg',
                      color: primary,
                      size: 22,
                    ),
            ),
          ],
        ),
      ),
      body: SafeArea(
        child: Column(
          children: [
            _buildPrivacyCard(),
            if (_error != null) _buildError(),
            Expanded(child: _buildMessages()),
            _buildMessageInput(),
          ],
        ),
      ),
    );
  }

  Widget _buildPrivacyCard() {
    return Container(
      margin: const EdgeInsets.fromLTRB(16, 16, 16, 8),
      padding: const EdgeInsets.all(14),
      decoration: BoxDecoration(
        color: primarySoft,
        borderRadius: BorderRadius.circular(14),
        border: Border.all(
          color: const Color(0xFFDBEAFE),
        ),
        boxShadow: [
          BoxShadow(
            color: primary.withOpacity(0.06),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Row(
        children: [
          Container(
            width: 40,
            height: 40,
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(11),
              boxShadow: [
                BoxShadow(
                  color: primary.withOpacity(0.1),
                  blurRadius: 8,
                  offset: const Offset(0, 3),
                ),
              ],
            ),
            padding: const EdgeInsets.all(10),
            child: _svg(
              asset: 'assets/icons/lock.svg',
              color: primary,
              size: 20,
            ),
          ),
          const SizedBox(width: 12),
          const Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  'Conversation privée',
                  style: TextStyle(
                    color: textDark,
                    fontWeight: FontWeight.bold,
                    fontSize: 14,
                    letterSpacing: -0.2,
                  ),
                ),
                SizedBox(height: 4),
                Text(
                  'Vos messages sont destinés à '
                  'l’administration de l’école.',
                  style: TextStyle(
                    color: textMuted,
                    fontSize: 12,
                    height: 1.4,
                    fontWeight: FontWeight.w500,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildError() {
    return Container(
      width: double.infinity,
      margin: const EdgeInsets.fromLTRB(16, 8, 16, 0),
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: const Color(0xFFFEF2F2),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(
          color: const Color(0xFFFECACA),
        ),
      ),
      child: Row(
        children: [
          _svg(
            asset: 'assets/icons/alert-circle.svg',
            color: const Color(0xFFDC2626),
            size: 18,
          ),
          const SizedBox(width: 10),
          Expanded(
            child: Text(
              _error!,
              style: const TextStyle(
                color: Color(0xFFB91C1C),
                fontSize: 12.5,
                fontWeight: FontWeight.w500,
              ),
            ),
          ),
          TextButton(
            onPressed: () => _loadMessages(),
            style: TextButton.styleFrom(
              foregroundColor: primary,
              padding: const EdgeInsets.symmetric(
                horizontal: 10,
              ),
              minimumSize: Size.zero,
              tapTargetSize: MaterialTapTargetSize.shrinkWrap,
            ),
            child: const Text(
              'Réessayer',
              style: TextStyle(
                fontSize: 12.5,
                fontWeight: FontWeight.bold,
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildMessages() {
    if (_loading) {
      return const Center(
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            SizedBox(
              width: 32,
              height: 32,
              child: CircularProgressIndicator(
                strokeWidth: 2.5,
                color: primary,
              ),
            ),
            SizedBox(height: 16),
            Text(
              'Chargement de la conversation...',
              style: TextStyle(
                color: textMuted,
                fontSize: 13,
                fontWeight: FontWeight.w500,
              ),
            ),
          ],
        ),
      );
    }

    if (_messages.isEmpty) {
      return Center(
        child: Padding(
          padding: const EdgeInsets.all(24),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Container(
                width: 110,
                height: 110,
                decoration: const BoxDecoration(
                  color: primarySoft,
                  shape: BoxShape.circle,
                ),
                alignment: Alignment.center,
                child: Container(
                  width: 78,
                  height: 78,
                  decoration: BoxDecoration(
                    color: Colors.white,
                    shape: BoxShape.circle,
                    boxShadow: [
                      BoxShadow(
                        color: primary.withOpacity(0.15),
                        blurRadius: 14,
                        offset: const Offset(0, 5),
                      ),
                    ],
                  ),
                  padding: const EdgeInsets.all(20),
                  child: _svg(
                    asset: 'assets/icons/chat.svg',
                    color: primary,
                    size: 38,
                  ),
                ),
              ),
              const SizedBox(height: 24),
              const Text(
                'Aucun message pour le moment',
                textAlign: TextAlign.center,
                style: TextStyle(
                  color: textDark,
                  fontSize: 18,
                  fontWeight: FontWeight.bold,
                  letterSpacing: -0.3,
                ),
              ),
              const SizedBox(height: 10),
              const Text(
                'Écrivez à l’administration pour démarrer '
                'votre conversation.',
                textAlign: TextAlign.center,
                style: TextStyle(
                  color: textMuted,
                  fontSize: 14,
                  height: 1.6,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ],
          ),
        ),
      );
    }

    return RefreshIndicator(
      color: primary,
      onRefresh: () => _loadMessages(),
      child: ListView.builder(
        controller: _scrollController,
        padding: const EdgeInsets.fromLTRB(16, 12, 16, 20),
        itemCount: _messages.length,
        itemBuilder: (context, index) {
          final message = _messages[index];
          final sender = message['sender'];

          final role = sender is Map
              ? sender['role']?.toString()
              : null;

          final isParent = role == 'parent';
          final body = message['body']?.toString() ?? '';

          final createdAt = message['created_at'];
          final dateText = _formaterHeure(createdAt);

          final senderName = sender is Map
              ? sender['name']?.toString() ?? ''
              : '';

          final initiales = _initiales(senderName);

          bool groupWithPrevious = false;

          if (index > 0) {
            final prevSender = _messages[index - 1]['sender'];

            final prevRole = prevSender is Map
                ? prevSender['role']?.toString()
                : null;

            groupWithPrevious = prevRole == role;
          }

          return _buildMessageBubble(
            body: body,
            isParent: isParent,
            dateText: dateText,
            initiales: initiales,
            groupWithPrevious: groupWithPrevious,
          );
        },
      ),
    );
  }

  Widget _buildMessageBubble({
    required String body,
    required bool isParent,
    required String dateText,
    required String initiales,
    required bool groupWithPrevious,
  }) {
    return Padding(
      padding: EdgeInsets.only(
        bottom: 10,
        top: groupWithPrevious ? 0 : 6,
      ),
      child: Row(
        mainAxisAlignment: isParent
            ? MainAxisAlignment.end
            : MainAxisAlignment.start,
        crossAxisAlignment: CrossAxisAlignment.end,
        children: [
          if (!isParent)
            Container(
              width: 32,
              height: 32,
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [primary, primaryDark],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),
                shape: BoxShape.circle,
                boxShadow: [
                  BoxShadow(
                    color: primary.withOpacity(0.25),
                    blurRadius: 8,
                    offset: const Offset(0, 3),
                  ),
                ],
              ),
              alignment: Alignment.center,
              child: Text(
                initiales,
                style: const TextStyle(
                  color: Colors.white,
                  fontSize: 11,
                  fontWeight: FontWeight.bold,
                  letterSpacing: 0.3,
                ),
              ),
            ),

          if (!isParent) const SizedBox(width: 8),

          Flexible(
            child: Container(
              constraints: BoxConstraints(
                maxWidth:
                    MediaQuery.of(context).size.width * 0.72,
              ),
              padding: const EdgeInsets.symmetric(
                horizontal: 14,
                vertical: 11,
              ),
              decoration: BoxDecoration(
                color: isParent ? primary : Colors.white,
                borderRadius: BorderRadius.only(
                  topLeft: const Radius.circular(16),
                  topRight: const Radius.circular(16),
                  bottomLeft:
                      Radius.circular(isParent ? 16 : 4),
                  bottomRight:
                      Radius.circular(isParent ? 4 : 16),
                ),
                border: isParent
                    ? null
                    : Border.all(color: border),
                boxShadow: [
                  BoxShadow(
                    color: isParent
                        ? primary.withOpacity(0.2)
                        : Colors.black.withOpacity(0.04),
                    blurRadius: 8,
                    offset: const Offset(0, 3),
                  ),
                ],
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisSize: MainAxisSize.min,
                children: [
                  Text(
                    isParent ? 'Vous' : 'Administration',
                    style: TextStyle(
                      color:
                          isParent ? Colors.white70 : primary,
                      fontSize: 11,
                      fontWeight: FontWeight.bold,
                      letterSpacing: 0.2,
                    ),
                  ),
                  const SizedBox(height: 5),
                  Text(
                    body,
                    style: TextStyle(
                      color: isParent ? Colors.white : textDark,
                      fontSize: 14,
                      height: 1.45,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                  if (dateText.isNotEmpty) ...[
                    const SizedBox(height: 6),
                    Text(
                      dateText,
                      style: TextStyle(
                        color:
                            isParent ? Colors.white60 : textMuted,
                        fontSize: 10,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                  ],
                ],
              ),
            ),
          ),

          if (isParent) const SizedBox(width: 8),

          if (isParent)
            Container(
              width: 32,
              height: 32,
              decoration: BoxDecoration(
                color: const Color(0xFF64748B),
                shape: BoxShape.circle,
                boxShadow: [
                  BoxShadow(
                    color: const Color(0xFF64748B)
                        .withOpacity(0.25),
                    blurRadius: 8,
                    offset: const Offset(0, 3),
                  ),
                ],
              ),
              alignment: Alignment.center,
              child: Text(
                initiales,
                style: const TextStyle(
                  color: Colors.white,
                  fontSize: 11,
                  fontWeight: FontWeight.bold,
                  letterSpacing: 0.3,
                ),
              ),
            ),
        ],
      ),
    );
  }

  Widget _buildMessageInput() {
    return Container(
      padding: const EdgeInsets.fromLTRB(12, 10, 12, 12),
      decoration: BoxDecoration(
        color: Colors.white,
        border: const Border(
          top: BorderSide(color: border),
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
            blurRadius: 10,
            offset: const Offset(0, -3),
          ),
        ],
      ),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.end,
        children: [
          Expanded(
            child: TextField(
              controller: _messageController,
              minLines: 1,
              maxLines: 4,
              textCapitalization: TextCapitalization.sentences,
              enabled: !_sending,
              onSubmitted: (_) => _sendMessage(),
              style: const TextStyle(
                color: textDark,
                fontSize: 14,
                fontWeight: FontWeight.w500,
              ),
              decoration: InputDecoration(
                hintText: 'Écrire un message...',
                hintStyle: const TextStyle(
                  color: textMuted,
                  fontSize: 14,
                  fontWeight: FontWeight.w500,
                ),
                filled: true,
                fillColor: background,
                contentPadding: const EdgeInsets.symmetric(
                  horizontal: 16,
                  vertical: 12,
                ),
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(14),
                  borderSide: BorderSide.none,
                ),
                enabledBorder: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(14),
                  borderSide: const BorderSide(color: border),
                ),
                focusedBorder: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(14),
                  borderSide: const BorderSide(
                    color: primary,
                    width: 1.5,
                  ),
                ),
              ),
            ),
          ),
          const SizedBox(width: 8),
          SizedBox(
            width: 48,
            height: 48,
            child: DecoratedBox(
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [primary, primaryDark],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),
                borderRadius: BorderRadius.circular(14),
                boxShadow: [
                  BoxShadow(
                    color: primary.withOpacity(0.3),
                    blurRadius: 10,
                    offset: const Offset(0, 4),
                  ),
                ],
              ),
              child: IconButton(
                tooltip: 'Envoyer',
                onPressed: _sending ? null : _sendMessage,
                icon: _sending
                    ? const SizedBox(
                        width: 20,
                        height: 20,
                        child: CircularProgressIndicator(
                          color: Colors.white,
                          strokeWidth: 2,
                        ),
                      )
                    : _svg(
                        asset: 'assets/icons/send.svg',
                        color: Colors.white,
                        size: 21,
                      ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  String _initiales(String name) {
    if (name.trim().isEmpty) return '?';

    final parts = name.trim().split(RegExp(r'\s+'));

    return parts
        .where((part) => part.isNotEmpty)
        .map((part) => part[0])
        .take(2)
        .join()
        .toUpperCase();
  }

  String _formaterHeure(dynamic value) {
    if (value == null || value.toString().isEmpty) {
      return '';
    }

    final date = DateTime.tryParse(value.toString());

    if (date == null) return '';

    final local = date.toLocal();
    final now = DateTime.now();
    final diff = now.difference(local);

    if (diff.inMinutes < 1) return 'À l’instant';

    if (diff.inMinutes < 60) {
      return 'Il y a ${diff.inMinutes} min';
    }

    if (diff.inHours < 24) {
      final h = local.hour.toString().padLeft(2, '0');
      final m = local.minute.toString().padLeft(2, '0');
      return '$h:$m';
    }

    final j = local.day.toString().padLeft(2, '0');
    final mo = local.month.toString().padLeft(2, '0');
    final h = local.hour.toString().padLeft(2, '0');
    final m = local.minute.toString().padLeft(2, '0');

    return '$j/$mo · $h:$m';
  }
}

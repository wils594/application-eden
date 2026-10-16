import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:url_launcher/url_launcher.dart';

import '../../services/api_service.dart';
import '../../core/theme/app_theme.dart'; // ✅ import corrigé

class AnnoncesScreen extends StatefulWidget {
  const AnnoncesScreen({super.key});

  // ═════════════════════════════════════════════
  // 🎨 COULEURS DE MARQUE (identiques Light/Dark)
  // ═════════════════════════════════════════════
  static const Color primary = AppTheme.primary;
  static const Color primaryDark = AppTheme.primaryDark;

  @override
  State<AnnoncesScreen> createState() => _AnnoncesScreenState();
}

class _AnnoncesScreenState extends State<AnnoncesScreen> {
  Future<Map<String, dynamic>>? _annoncesFuture;

  @override
  void initState() {
    super.initState();
    _chargerAnnonces();
  }

  void _chargerAnnonces() {
    setState(() {
      _annoncesFuture = ApiService.get('/annonces');
    });
  }

  Widget _svg({
    required String asset,
    required Color color,
    double size = 22,
  }) {
    return SvgPicture.asset(
      asset,
      width: size,
      height: size,
      colorFilter: ColorFilter.mode(color, BlendMode.srcIn),
    );
  }

  Color _couleurCategorie(String category) {
    switch (category.toLowerCase()) {
      case 'urgent':
        return const Color(0xFFDC2626);
      case 'activite':
      case 'activité':
        return const Color(0xFF16A34A);
      case 'evenement':
      case 'événement':
        return const Color(0xFF8B5CF6);
      case 'information':
      default:
        return AppTheme.primary; // ← Bleu par défaut
    }
  }

  /// ✅ Extraction multi-clés (annoncements, data, annonces, liste)
  List<dynamic> _extraireAnnonces(Map<String, dynamic> data) {
    if (data['announcements'] is List) return data['announcements'] as List;
    if (data['data'] is List) return data['data'] as List;
    if (data['annonces'] is List) return data['annonces'] as List;
    if (data is List) return data as List;
    for (final key in data.keys) {
      if (key.toString().toLowerCase().contains('annonce')) {
        final value = data[key];
        if (value is List) return value;
      }
    }
    return [];
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      appBar: AppBar(
        elevation: 0,
        scrolledUnderElevation: 0,
        centerTitle: false,
        titleSpacing: 20,
        title: Row(
          children: [
            _GlowingMegaphoneLogo(
              svgBuilder: (color, size) => _svg(
                asset: 'assets/icons/megaphone.svg',
                color: color,
                size: size,
              ),
            ),
            const SizedBox(width: 12),
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisSize: MainAxisSize.min,
              children: [
                Text(
                  'Annonces',
                  style: TextStyle(
                    color: AppTheme.textDark(context),
                    fontSize: 17,
                    fontWeight: FontWeight.bold,
                    letterSpacing: -0.3,
                  ),
                ),
                const SizedBox(height: 2),
                Text(
                  'Fil de l\u2019école',
                  style: TextStyle(
                    color: AppTheme.textMuted(context),
                    fontSize: 11,
                    fontWeight: FontWeight.w500,
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
      body: SafeArea(
        child: RefreshIndicator(
          onRefresh: () async {
            final future = ApiService.get('/annonces');

            setState(() {
              _annoncesFuture = future;
            });

            await future;
          },
          color: AppTheme.primary,
          child: ListView(
            physics: const AlwaysScrollableScrollPhysics(),
            padding: const EdgeInsets.all(12),
            children: [
              _buildWelcomeCard(),
              const SizedBox(height: 16),
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 4),
                child: Text(
                  'Publications de l\u2019école',
                  style: TextStyle(
                    color: AppTheme.textDark(context),
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                    letterSpacing: -0.3,
                  ),
                ),
              ),
              const SizedBox(height: 12),
              FutureBuilder<Map<String, dynamic>>(
                future: _annoncesFuture,
                builder: (context, snapshot) {
                  if (snapshot.connectionState ==
                      ConnectionState.waiting) {
                    return _buildLoading();
                  }

                  if (snapshot.hasError) {
                    return _buildError(snapshot.error.toString());
                  }

                  final data = snapshot.data ?? {};
                  final annonces = _extraireAnnonces(data);

                  debugPrint('🔍 Annonces trouvées : ${annonces.length}');

                  if (annonces.isEmpty) {
                    return _buildEmptyState();
                  }

                  return Column(
                    children: List.generate(annonces.length, (index) {
                      final item = annonces[index];

                      if (item is! Map) {
                        return const SizedBox.shrink();
                      }

                      final annonce = Map<String, dynamic>.from(item);

                      return _FadeSlideIn(
                        delay: index * 70,
                        child: _buildFacebookPost(annonce),
                      );
                    }),
                  );
                },
              ),
              const SizedBox(height: 16),
              Center(
                child: Text(
                  'Tirez vers le bas pour actualiser',
                  style: TextStyle(
                    color: AppTheme.textMuted(context),
                    fontSize: 11.5,
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildWelcomeCard() {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          colors: [
            AppTheme.primary,
            AppTheme.primaryDark,
          ],
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
        ),
        borderRadius: BorderRadius.circular(14),
        boxShadow: [
          BoxShadow(
            color: AppTheme.primary.withOpacity(0.3),
            blurRadius: 16,
            offset: const Offset(0, 8),
          ),
        ],
      ),
      child: Row(
        children: [
          Container(
            width: 46,
            height: 46,
            decoration: BoxDecoration(
              color: Colors.white.withOpacity(0.22),
              shape: BoxShape.circle,
              border: Border.all(
                color: Colors.white.withOpacity(0.35),
                width: 1.5,
              ),
            ),
            padding: const EdgeInsets.all(12),
            child: SvgPicture.asset(
              'assets/icons/megaphone.svg',
              colorFilter: const ColorFilter.mode(
                Colors.white,
                BlendMode.srcIn,
              ),
            ),
          ),
          const SizedBox(width: 12),
          const Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  'Restez informés',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 15,
                    fontWeight: FontWeight.bold,
                    letterSpacing: -0.3,
                  ),
                ),
                SizedBox(height: 4),
                Text(
                  'Suivez les publications de l\u2019école.',
                  style: TextStyle(
                    color: Colors.white70,
                    fontSize: 12,
                    height: 1.4,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildLoading() {
    return Container(
      padding: const EdgeInsets.all(28),
      decoration: BoxDecoration(
        color: AppTheme.cardColor(context),
        borderRadius: BorderRadius.circular(12),
      ),
      child: Column(
        children: [
          const SizedBox(
            width: 28,
            height: 28,
            child: CircularProgressIndicator(
              strokeWidth: 2.5,
              color: AppTheme.primary,
            ),
          ),
          const SizedBox(height: 14),
          Text(
            'Chargement des annonces...',
            style: TextStyle(
              color: AppTheme.textMuted(context),
              fontSize: 13,
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildError(String error) {
    return Container(
      padding: const EdgeInsets.all(22),
      decoration: BoxDecoration(
        color: AppTheme.cardColor(context),
        borderRadius: BorderRadius.circular(12),
      ),
      child: Column(
        children: [
          Container(
            width: 80,
            height: 80,
            decoration: const BoxDecoration(
              color: Color(0xFFFEF2F2),
              shape: BoxShape.circle,
            ),
            alignment: Alignment.center,
            child: _svg(
              asset: 'assets/icons/cloud-off.svg',
              color: Colors.red.shade700,
              size: 34,
            ),
          ),
          const SizedBox(height: 18),
          Text(
            'Impossible de charger les annonces',
            textAlign: TextAlign.center,
            style: TextStyle(
              color: AppTheme.textDark(context),
              fontSize: 15,
              fontWeight: FontWeight.bold,
              letterSpacing: -0.3,
            ),
          ),
          const SizedBox(height: 8),
          Text(
            error.replaceFirst('Exception: ', ''),
            textAlign: TextAlign.center,
            maxLines: 4,
            overflow: TextOverflow.ellipsis,
            style: TextStyle(
              color: AppTheme.textMuted(context),
              fontSize: 12.5,
              height: 1.5,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 18),
          _RetryButton(
            onTap: _chargerAnnonces,
            svgBuilder: (color, size) => _svg(
              asset: 'assets/icons/refresh.svg',
              color: color,
              size: size,
            ),
          ),
        ],
      ),
    );
  }

  // ═════════════════════════════════════════════════
  // 📘 POST STYLE FACEBOOK
  // ═════════════════════════════════════════════════

  Widget _buildFacebookPost(Map<String, dynamic> annonce) {
    final title = annonce['title']?.toString() ?? 'Sans titre';
    final content = annonce['content']?.toString() ?? '';
    final category = annonce['category']?.toString() ?? 'information';
    final dateText = _formaterDate(annonce['published_at']);
    final attachmentUrl = annonce['attachment_url']?.toString();

    final accentColor = _couleurCategorie(category);

    final lowerUrl = attachmentUrl?.toLowerCase() ?? '';
    final isImage = lowerUrl.endsWith('.jpg') ||
        lowerUrl.endsWith('.jpeg') ||
        lowerUrl.endsWith('.png') ||
        lowerUrl.endsWith('.webp') ||
        lowerUrl.endsWith('.gif');
    final isPdf = lowerUrl.endsWith('.pdf');
    final hasAttachment =
        attachmentUrl != null && attachmentUrl.isNotEmpty;

    return _PressablePostCard(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: [
          // ═════════════════════════════════════════
          // 👤 EN-TÊTE DU POST (style Facebook)
          // ═════════════════════════════════════════
          Padding(
            padding: const EdgeInsets.all(12),
            child: Row(
              children: [
                // Avatar (bleu)
                Container(
                  width: 44,
                  height: 44,
                  decoration: BoxDecoration(
                    gradient: const LinearGradient(
                      colors: [
                        AppTheme.primary,
                        AppTheme.primaryDark,
                      ],
                      begin: Alignment.topLeft,
                      end: Alignment.bottomRight,
                    ),
                    shape: BoxShape.circle,
                    boxShadow: [
                      BoxShadow(
                        color: AppTheme.primary.withOpacity(0.3),
                        blurRadius: 8,
                        offset: const Offset(0, 3),
                      ),
                    ],
                  ),
                  alignment: Alignment.center,
                  child: const Text(
                    'EA',
                    style: TextStyle(
                      color: Colors.white,
                      fontSize: 15,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ),

                const SizedBox(width: 10),

                // Nom + date + catégorie
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'École Eden',
                        style: TextStyle(
                          color: AppTheme.textDark(context),
                          fontSize: 14.5,
                          fontWeight: FontWeight.bold,
                          letterSpacing: -0.2,
                        ),
                      ),
                      const SizedBox(height: 3),
                      Row(
                        children: [
                          Text(
                            dateText,
                            style: TextStyle(
                              color: AppTheme.textMuted(context),
                              fontSize: 11.5,
                              fontWeight: FontWeight.w500,
                            ),
                          ),
                          const SizedBox(width: 6),
                          Container(
                            width: 3,
                            height: 3,
                            decoration: BoxDecoration(
                              color: AppTheme.textMuted(context),
                              shape: BoxShape.circle,
                            ),
                          ),
                          const SizedBox(width: 6),
                          Container(
                            padding: const EdgeInsets.symmetric(
                              horizontal: 6,
                              vertical: 2,
                            ),
                            decoration: BoxDecoration(
                              color: accentColor.withOpacity(0.12),
                              borderRadius: BorderRadius.circular(20),
                            ),
                            child: Text(
                              _libelleCategorie(category),
                              style: TextStyle(
                                color: accentColor,
                                fontSize: 10,
                                fontWeight: FontWeight.w600,
                                letterSpacing: 0.2,
                              ),
                            ),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),

                // Menu (3 points)
                _svg(
                  asset: 'assets/icons/more.svg',
                  color: AppTheme.textMuted(context),
                  size: 20,
                ),
              ],
            ),
          ),

          // ═════════════════════════════════════════
          // 📝 CONTENU (texte du post)
          // ═════════════════════════════════════════
          Padding(
            padding: const EdgeInsets.fromLTRB(12, 0, 12, 12),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Titre en gras
                Text(
                  title,
                  style: TextStyle(
                    color: AppTheme.textDark(context),
                    fontSize: 15,
                    fontWeight: FontWeight.bold,
                    height: 1.35,
                    letterSpacing: -0.2,
                  ),
                ),

                // Contenu
                if (content.isNotEmpty) ...[
                  const SizedBox(height: 8),
                  Text(
                    content,
                    style: TextStyle(
                      color: AppTheme.textDark(context),
                      fontSize: 14,
                      height: 1.55,
                      fontWeight: FontWeight.w400,
                    ),
                  ),
                ],
              ],
            ),
          ),

          // ═════════════════════════════════════════
          // 🖼️ IMAGE (pleine largeur, sans padding)
          // ═════════════════════════════════════════
          if (hasAttachment && isImage)
            GestureDetector(
              onTap: () => _ouvrirLien(attachmentUrl),
              child: Container(
                width: double.infinity,
                constraints: const BoxConstraints(maxHeight: 320),
                color: AppTheme.primarySoftColor(context),
                child: Image.network(
                  attachmentUrl,
                  fit: BoxFit.cover,
                  loadingBuilder: (context, child, progress) {
                    if (progress == null) return child;
                    return Container(
                      height: 200,
                      color: AppTheme.primarySoftColor(context),
                      alignment: Alignment.center,
                      child: const SizedBox(
                        width: 26,
                        height: 26,
                        child: CircularProgressIndicator(
                          strokeWidth: 2.5,
                          color: AppTheme.primary,
                        ),
                      ),
                    );
                  },
                  errorBuilder: (context, error, stackTrace) {
                    return Container(
                      height: 120,
                      color: AppTheme.primarySoftColor(context),
                      alignment: Alignment.center,
                      child: Column(
                        mainAxisSize: MainAxisSize.min,
                        children: [
                          _svg(
                            asset: 'assets/icons/file-text.svg',
                            color: AppTheme.primaryDark,
                            size: 28,
                          ),
                          const SizedBox(height: 6),
                          Text(
                            'Image non disponible',
                            style: TextStyle(
                              color: AppTheme.textMuted(context),
                              fontSize: 12,
                              fontWeight: FontWeight.w500,
                            ),
                          ),
                        ],
                      ),
                    );
                  },
                ),
              ),
            ),

          // ═════════════════════════════════════════
          // 📄 PIÈCE JOINTE (PDF ou fichier)
          // ═════════════════════════════════════════
          if (hasAttachment && isPdf)
            Padding(
              padding: const EdgeInsets.all(12),
              child: _buildAttachment(
                url: attachmentUrl,
                iconColor: const Color(0xFFDC2626),
                iconBg: const Color(0xFFFEF2F2),
                title: 'Document PDF',
              ),
            )
          else if (hasAttachment && !isImage && !isPdf)
            Padding(
              padding: const EdgeInsets.all(12),
              child: _buildAttachment(
                url: attachmentUrl,
                iconColor: AppTheme.primaryDark,
                iconBg: AppTheme.primarySoftColor(context),
                title: 'Fichier joint',
              ),
            ),

          // ═════════════════════════════════════════
          // 👍 BARRE D'ACTIONS (style Facebook)
          // ═════════════════════════════════════════
          Divider(height: 1, color: AppTheme.border(context)),

          Padding(
            padding: const EdgeInsets.symmetric(
              horizontal: 8,
              vertical: 6,
            ),
            child: Row(
              children: [
                Expanded(
                  child: _buildActionButton(
                    iconAsset: 'assets/icons/thumbs-up.svg',
                    label: 'J\u2019aime',
                  ),
                ),
                Expanded(
                  child: _buildActionButton(
                    iconAsset: 'assets/icons/message.svg',
                    label: 'Commenter',
                  ),
                ),
                Expanded(
                  child: _buildActionButton(
                    iconAsset: 'assets/icons/share.svg',
                    label: 'Partager',
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  // ── Bouton d'action (J'aime / Commenter / Partager) ──
  Widget _buildActionButton({
    required String iconAsset,
    required String label,
  }) {
    final actionColor = AppTheme.isDark(context)
        ? const Color(0xFFB0B3B8)
        : const Color(0xFF65676B);

    return Material(
      color: Colors.transparent,
      borderRadius: BorderRadius.circular(8),
      child: InkWell(
        borderRadius: BorderRadius.circular(8),
        onTap: () {},
        child: Padding(
          padding: const EdgeInsets.symmetric(
            horizontal: 8,
            vertical: 8,
          ),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              _svg(
                asset: iconAsset,
                color: actionColor,
                size: 18,
              ),
              const SizedBox(width: 6),
              Text(
                label,
                style: TextStyle(
                  color: actionColor,
                  fontSize: 12.5,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  // ── Pièce jointe (PDF/générique) ──
  Widget _buildAttachment({
    required String url,
    required Color iconColor,
    required Color iconBg,
    required String title,
  }) {
    return Material(
      color: Colors.transparent,
      borderRadius: BorderRadius.circular(10),
      child: InkWell(
        borderRadius: BorderRadius.circular(10),
        onTap: () => _ouvrirLien(url),
        child: Container(
          padding: const EdgeInsets.all(12),
          decoration: BoxDecoration(
            color: Theme.of(context).scaffoldBackgroundColor,
            borderRadius: BorderRadius.circular(10),
            border: Border.all(color: AppTheme.border(context)),
          ),
          child: Row(
            children: [
              Container(
                width: 40,
                height: 40,
                decoration: BoxDecoration(
                  color: iconBg,
                  borderRadius: BorderRadius.circular(10),
                ),
                padding: const EdgeInsets.all(9),
                child: _svg(
                  asset: 'assets/icons/file-text.svg',
                  color: iconColor,
                  size: 22,
                ),
              ),
              const SizedBox(width: 10),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      title,
                      style: TextStyle(
                        color: AppTheme.textDark(context),
                        fontSize: 13.5,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                    const SizedBox(height: 2),
                    Text(
                      'Appuyez pour ouvrir',
                      style: TextStyle(
                        color: AppTheme.textMuted(context),
                        fontSize: 11.5,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                  ],
                ),
              ),
              _svg(
                asset: 'assets/icons/chevron_right.svg',
                color: AppTheme.textMuted(context),
                size: 18,
              ),
            ],
          ),
        ),
      ),
    );
  }

  Future<void> _ouvrirLien(String url) async {
    final uri = Uri.tryParse(url);
    if (uri == null) return;

    final ok = await launchUrl(
      uri,
      mode: LaunchMode.externalApplication,
    );

    if (!ok && mounted) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Impossible d\u2019ouvrir la pièce jointe.'),
        ),
      );
    }
  }

  String _libelleCategorie(String category) {
    switch (category.toLowerCase()) {
      case 'information':
        return 'Information';
      case 'activite':
      case 'activité':
        return 'Activité';
      case 'evenement':
      case 'événement':
        return 'Événement';
      case 'urgent':
        return 'Urgent';
      default:
        return category;
    }
  }

  String _formaterDate(dynamic value) {
    if (value == null || value.toString().isEmpty) return '';

    final date = DateTime.tryParse(value.toString());
    if (date == null) return '';

    final local = date.toLocal();
    final now = DateTime.now();
    final diff = now.difference(local);

    // Date relative style Facebook
    if (diff.inMinutes < 1) return 'À l\u2019instant';
    if (diff.inMinutes < 60) return 'Il y a ${diff.inMinutes} min';
    if (diff.inHours < 24) return 'Il y a ${diff.inHours} h';
    if (diff.inDays < 7) return 'Il y a ${diff.inDays} j';

    final jour = local.day.toString().padLeft(2, '0');
    final mois = local.month.toString().padLeft(2, '0');
    final annee = local.year;

    return '$jour/$mois/$annee';
  }

  Widget _buildEmptyState() {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.symmetric(
        horizontal: 22,
        vertical: 32,
      ),
      decoration: BoxDecoration(
        color: AppTheme.cardColor(context),
        borderRadius: BorderRadius.circular(12),
      ),
      child: Column(
        children: [
          Container(
            width: 80,
            height: 80,
            decoration: BoxDecoration(
              color: AppTheme.primarySoftColor(context),
              shape: BoxShape.circle,
            ),
            alignment: Alignment.center,
            child: _svg(
              asset: 'assets/icons/bell_off.svg',
              color: AppTheme.primaryDark,
              size: 30,
            ),
          ),
          const SizedBox(height: 18),
          Text(
            'Aucune annonce pour le moment',
            textAlign: TextAlign.center,
            style: TextStyle(
              color: AppTheme.textDark(context),
              fontSize: 15,
              fontWeight: FontWeight.bold,
              letterSpacing: -0.3,
            ),
          ),
          const SizedBox(height: 8),
          Text(
            'Les prochains communiqués apparaîtront ici.',
            textAlign: TextAlign.center,
            style: TextStyle(
              color: AppTheme.textMuted(context),
              fontSize: 12.5,
              height: 1.5,
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }
}

// ═════════════════════════════════════════════════
// 🌟 LOGO GLOW BLEU
// ═════════════════════════════════════════════════

class _GlowingMegaphoneLogo extends StatefulWidget {
  final Widget Function(Color color, double size) svgBuilder;

  const _GlowingMegaphoneLogo({required this.svgBuilder});

  @override
  State<_GlowingMegaphoneLogo> createState() =>
      _GlowingMegaphoneLogoState();
}

class _GlowingMegaphoneLogoState extends State<_GlowingMegaphoneLogo>
    with SingleTickerProviderStateMixin {
  late AnimationController _controller;

  @override
  void initState() {
    super.initState();
    _controller = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 2000),
    )..repeat(reverse: true);
  }

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return TweenAnimationBuilder<double>(
      tween: Tween(begin: 0.0, end: 1.0),
      duration: const Duration(milliseconds: 600),
      curve: Curves.easeOutBack,
      builder: (context, value, child) =>
          Transform.scale(scale: value, child: child),
      child: AnimatedBuilder(
        animation: _controller,
        builder: (context, child) {
          final glow = 0.2 + (_controller.value * 0.2);
          return Container(
            width: 42,
            height: 42,
            decoration: BoxDecoration(
              gradient: const LinearGradient(
                colors: [
                  AppTheme.primary,
                  AppTheme.primaryDark,
                ],
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
              ),
              borderRadius: BorderRadius.circular(12),
              boxShadow: [
                BoxShadow(
                  color: AppTheme.primary.withOpacity(glow),
                  blurRadius: 14 + (_controller.value * 10),
                  spreadRadius: _controller.value * 1.5,
                ),
              ],
            ),
            padding: const EdgeInsets.all(10),
            child: widget.svgBuilder(Colors.white, 22),
          );
        },
      ),
    );
  }
}

// ═════════════════════════════════════════════════
// 🔄 BOUTON RÉESSAYER BLEU
// ═════════════════════════════════════════════════

class _RetryButton extends StatefulWidget {
  final VoidCallback onTap;
  final Widget Function(Color color, double size) svgBuilder;

  const _RetryButton({
    required this.onTap,
    required this.svgBuilder,
  });

  @override
  State<_RetryButton> createState() => _RetryButtonState();
}

class _RetryButtonState extends State<_RetryButton> {
  bool _pressed = false;

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTapDown: (_) => setState(() => _pressed = true),
      onTapUp: (_) => setState(() => _pressed = false),
      onTapCancel: () => setState(() => _pressed = false),
      onTap: widget.onTap,
      child: AnimatedScale(
        scale: _pressed ? 0.96 : 1.0,
        duration: const Duration(milliseconds: 120),
        child: Container(
          padding: const EdgeInsets.symmetric(
            horizontal: 20,
            vertical: 11,
          ),
          decoration: BoxDecoration(
            color: AppTheme.primary,
            borderRadius: BorderRadius.circular(10),
            boxShadow: [
              BoxShadow(
                color: AppTheme.primary.withOpacity(0.35),
                blurRadius: 12,
                offset: const Offset(0, 5),
              ),
            ],
          ),
          child: Row(
            mainAxisSize: MainAxisSize.min,
            children: [
              widget.svgBuilder(Colors.white, 15),
              const SizedBox(width: 8),
              const Text(
                'Réessayer',
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 13.5,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

// ═════════════════════════════════════════════════
// 📘 CARTE POST PRESSABLE
// ═════════════════════════════════════════════════

class _PressablePostCard extends StatefulWidget {
  final Widget child;

  const _PressablePostCard({required this.child});

  @override
  State<_PressablePostCard> createState() => _PressablePostCardState();
}

class _PressablePostCardState extends State<_PressablePostCard> {
  bool _isHovered = false;

  @override
  Widget build(BuildContext context) {
    return MouseRegion(
      onEnter: (_) => setState(() => _isHovered = true),
      onExit: (_) => setState(() => _isHovered = false),
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 200),
        curve: Curves.easeOutCubic,
        margin: const EdgeInsets.only(bottom: 10),
        decoration: BoxDecoration(
          color: AppTheme.cardColor(context),
          borderRadius: BorderRadius.circular(12),
          border: _isHovered
              ? Border.all(
                  color: AppTheme.primary.withOpacity(0.2),
                )
              : null,
          boxShadow: [
            BoxShadow(
              color: _isHovered
                  ? AppTheme.primary.withOpacity(0.1)
                  : Colors.black.withOpacity(0.04),
              blurRadius: _isHovered ? 16 : 8,
              offset: Offset(0, _isHovered ? 4 : 2),
            ),
          ],
        ),
        child: widget.child,
      ),
    );
  }
}

// ═════════════════════════════════════════════════
// ✨ APPARITION EN CASCADE
// ═════════════════════════════════════════════════

class _FadeSlideIn extends StatefulWidget {
  final Widget child;
  final int delay;

  const _FadeSlideIn({
    required this.child,
    this.delay = 0,
  });

  @override
  State<_FadeSlideIn> createState() => _FadeSlideInState();
}

class _FadeSlideInState extends State<_FadeSlideIn>
    with SingleTickerProviderStateMixin {
  late AnimationController _controller;
  late Animation<double> _opacity;
  late Animation<Offset> _slide;

  @override
  void initState() {
    super.initState();
    _controller = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 450),
    );

    _opacity = CurvedAnimation(parent: _controller, curve: Curves.easeOut);

    _slide = Tween<Offset>(
      begin: const Offset(0, 0.1),
      end: Offset.zero,
    ).animate(
      CurvedAnimation(parent: _controller, curve: Curves.easeOutCubic),
    );

    Future.delayed(Duration(milliseconds: widget.delay), () {
      if (mounted) _controller.forward();
    });
  }

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return FadeTransition(
      opacity: _opacity,
      child: SlideTransition(position: _slide, child: widget.child),
    );
  }
}
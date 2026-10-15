import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:url_launcher/url_launcher.dart';

import '../../services/api_service.dart';

class AnnoncesScreen extends StatefulWidget {
  const AnnoncesScreen({super.key});

  static const Color primary = Color(0xFF2563EB);
  static const Color primaryDark = Color(0xFF1D4ED8);
  static const Color textDark = Color(0xFF111827);
  static const Color textMuted = Color(0xFF6B7280);
  static const Color background = Color(0xFFF7F9FC);
  static const Color border = Color(0xFFE5E7EB);
  static const Color primarySoft = Color(0xFFEFF6FF);

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
    Color color = AnnoncesScreen.textDark,
    double size = 22,
  }) {
    return SvgPicture.asset(
      asset,
      width: size,
      height: size,
      colorFilter: ColorFilter.mode(color, BlendMode.srcIn),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AnnoncesScreen.background,
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
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [
                    AnnoncesScreen.primary,
                    AnnoncesScreen.primaryDark,
                  ],
                ),
                borderRadius: BorderRadius.circular(12),
                boxShadow: [
                  BoxShadow(
                    color: AnnoncesScreen.primary.withOpacity(0.25),
                    blurRadius: 10,
                    offset: const Offset(0, 4),
                  ),
                ],
              ),
              padding: const EdgeInsets.all(10),
              child: SvgPicture.asset(
                'assets/icons/megaphone.svg',
                colorFilter: const ColorFilter.mode(
                  Colors.white,
                  BlendMode.srcIn,
                ),
              ),
            ),
            const SizedBox(width: 12),
            const Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisSize: MainAxisSize.min,
              children: [
                Text(
                  'Annonces de l’école',
                  style: TextStyle(
                    color: AnnoncesScreen.textDark,
                    fontSize: 17,
                    fontWeight: FontWeight.bold,
                    letterSpacing: -0.3,
                  ),
                ),
                SizedBox(height: 2),
                Text(
                  'Les informations importantes',
                  style: TextStyle(
                    color: AnnoncesScreen.textMuted,
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
          color: AnnoncesScreen.primary,
          child: ListView(
            physics: const AlwaysScrollableScrollPhysics(),
            padding: const EdgeInsets.all(20),
            children: [
              _buildWelcomeCard(),
              const SizedBox(height: 28),
              const Text(
                'Actualités et communiqués',
                style: TextStyle(
                  color: AnnoncesScreen.textDark,
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                  letterSpacing: -0.3,
                ),
              ),
              const SizedBox(height: 8),
              const Text(
                'Retrouvez ici les annonces, les activités '
                'et les informations communiquées par l’école.',
                style: TextStyle(
                  color: AnnoncesScreen.textMuted,
                  fontSize: 14,
                  height: 1.5,
                  fontWeight: FontWeight.w500,
                ),
              ),
              const SizedBox(height: 22),
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
                  final rawAnnonces = data['announcements'];

                  final annonces = rawAnnonces is List
                      ? rawAnnonces
                      : <dynamic>[];

                  if (annonces.isEmpty) {
                    return _buildEmptyState();
                  }

                  return Column(
                    children: annonces.map<Widget>((item) {
                      if (item is! Map) {
                        return const SizedBox.shrink();
                      }

                      return _buildAnnonce(
                        Map<String, dynamic>.from(item),
                      );
                    }).toList(),
                  );
                },
              ),
              const SizedBox(height: 20),
              const Center(
                child: Text(
                  'Tirez vers le bas pour actualiser',
                  style: TextStyle(
                    color: AnnoncesScreen.textMuted,
                    fontSize: 12,
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
      padding: const EdgeInsets.all(22),
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          colors: [
            AnnoncesScreen.primary,
            AnnoncesScreen.primaryDark,
          ],
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
        ),
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: AnnoncesScreen.primary.withOpacity(0.25),
            blurRadius: 20,
            offset: const Offset(0, 10),
          ),
        ],
      ),
      child: Row(
        children: [
          Container(
            width: 58,
            height: 58,
            decoration: BoxDecoration(
              color: Colors.white.withOpacity(0.18),
              shape: BoxShape.circle,
              border: Border.all(
                color: Colors.white.withOpacity(0.25),
                width: 1.5,
              ),
            ),
            padding: const EdgeInsets.all(15),
            child: SvgPicture.asset(
              'assets/icons/megaphone.svg',
              colorFilter: const ColorFilter.mode(
                Colors.white,
                BlendMode.srcIn,
              ),
            ),
          ),
          const SizedBox(width: 16),
          const Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  'Restez informés',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                    letterSpacing: -0.3,
                  ),
                ),
                SizedBox(height: 8),
                Text(
                  'Suivez les nouvelles, les événements '
                  'et les communications de l’établissement.',
                  style: TextStyle(
                    color: Colors.white70,
                    fontSize: 13,
                    height: 1.5,
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
      padding: const EdgeInsets.all(35),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: AnnoncesScreen.border),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        children: [
          const SizedBox(
            width: 32,
            height: 32,
            child: CircularProgressIndicator(
              strokeWidth: 2.5,
              color: AnnoncesScreen.primary,
            ),
          ),
          const SizedBox(height: 18),
          const Text(
            'Chargement des annonces...',
            style: TextStyle(
              color: AnnoncesScreen.textMuted,
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildError(String error) {
    return Container(
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: AnnoncesScreen.border),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        children: [
          Container(
            width: 96,
            height: 96,
            decoration: const BoxDecoration(
              color: Color(0xFFFEF2F2),
              shape: BoxShape.circle,
            ),
            alignment: Alignment.center,
            child: _svg(
              asset: 'assets/icons/cloud-off.svg',
              color: Colors.red.shade700,
              size: 42,
            ),
          ),
          const SizedBox(height: 22),

          const Text(
            'Impossible de charger les annonces',
            textAlign: TextAlign.center,
            style: TextStyle(
              color: AnnoncesScreen.textDark,
              fontSize: 17,
              fontWeight: FontWeight.bold,
              letterSpacing: -0.3,
            ),
          ),
          const SizedBox(height: 10),

          Text(
            error.replaceFirst('Exception: ', ''),
            textAlign: TextAlign.center,
            style: const TextStyle(
              color: AnnoncesScreen.textMuted,
              fontSize: 13.5,
              height: 1.5,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 22),

          Material(
            color: Colors.transparent,
            borderRadius: BorderRadius.circular(10),
            child: InkWell(
              borderRadius: BorderRadius.circular(10),
              onTap: _chargerAnnonces,
              child: Container(
                padding: const EdgeInsets.symmetric(
                  horizontal: 22,
                  vertical: 12,
                ),
                decoration: BoxDecoration(
                  color: AnnoncesScreen.primary,
                  borderRadius: BorderRadius.circular(10),
                  boxShadow: [
                    BoxShadow(
                      color: AnnoncesScreen.primary.withOpacity(0.3),
                      blurRadius: 10,
                      offset: const Offset(0, 4),
                    ),
                  ],
                ),
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    _svg(
                      asset: 'assets/icons/refresh.svg',
                      color: Colors.white,
                      size: 16,
                    ),
                    const SizedBox(width: 8),
                    const Text(
                      'Réessayer',
                      style: TextStyle(
                        color: Colors.white,
                        fontSize: 14,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildAnnonce(Map<String, dynamic> annonce) {
    final title = annonce['title']?.toString() ?? 'Sans titre';
    final content = annonce['content']?.toString() ?? '';
    final category = annonce['category']?.toString() ?? 'information';
    final dateText = _formaterDate(annonce['published_at']);
    final attachmentUrl = annonce['attachment_url']?.toString();

    return Container(
      width: double.infinity,
      margin: const EdgeInsets.only(bottom: 16),
      padding: const EdgeInsets.all(18),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(18),
        border: Border.all(color: AnnoncesScreen.border),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.025),
            blurRadius: 10,
            offset: const Offset(0, 3),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // ── En-tête : icône + titre + badges ──
          Row(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Container(
                width: 46,
                height: 46,
                decoration: BoxDecoration(
                  gradient: const LinearGradient(
                    colors: [
                      AnnoncesScreen.primary,
                      AnnoncesScreen.primaryDark,
                    ],
                    begin: Alignment.topLeft,
                    end: Alignment.bottomRight,
                  ),
                  borderRadius: BorderRadius.circular(12),
                  boxShadow: [
                    BoxShadow(
                      color: AnnoncesScreen.primary.withOpacity(0.25),
                      blurRadius: 10,
                      offset: const Offset(0, 4),
                    ),
                  ],
                ),
                padding: const EdgeInsets.all(11),
                child: SvgPicture.asset(
                  'assets/icons/megaphone.svg',
                  colorFilter: const ColorFilter.mode(
                    Colors.white,
                    BlendMode.srcIn,
                  ),
                ),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      title,
                      style: const TextStyle(
                        color: AnnoncesScreen.textDark,
                        fontSize: 16,
                        fontWeight: FontWeight.bold,
                        height: 1.4,
                        letterSpacing: -0.2,
                      ),
                    ),
                    const SizedBox(height: 8),
                    Wrap(
                      spacing: 8,
                      runSpacing: 6,
                      crossAxisAlignment: WrapCrossAlignment.center,
                      children: [
                        Container(
                          padding: const EdgeInsets.symmetric(
                            horizontal: 10,
                            vertical: 5,
                          ),
                          decoration: BoxDecoration(
                            color: AnnoncesScreen.primarySoft,
                            borderRadius: BorderRadius.circular(20),
                          ),
                          child: Text(
                            _libelleCategorie(category),
                            style: const TextStyle(
                              color: AnnoncesScreen.primaryDark,
                              fontSize: 11,
                              fontWeight: FontWeight.w600,
                            ),
                          ),
                        ),
                        Text(
                          dateText,
                          style: const TextStyle(
                            color: AnnoncesScreen.textMuted,
                            fontSize: 11,
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ],
          ),

          // ── Contenu ──
          if (content.isNotEmpty) ...[
            const SizedBox(height: 16),
            const Divider(height: 1, color: AnnoncesScreen.border),
            const SizedBox(height: 14),
            Text(
              content,
              style: const TextStyle(
                color: AnnoncesScreen.textMuted,
                fontSize: 14,
                height: 1.65,
              ),
            ),
          ],

          // ── Pièce jointe (image ou PDF) ──
          if (attachmentUrl != null && attachmentUrl.isNotEmpty) ...[
            const SizedBox(height: 16),
            _buildPieceJointe(attachmentUrl),
          ],
        ],
      ),
    );
  }

  // ─────────────────────────────────────────────
  // Pièce jointe (aperçu comme dans Yass)
  // ─────────────────────────────────────────────

  Widget _buildPieceJointe(String url) {
    final lowerUrl = url.toLowerCase();

    final isImage =
        lowerUrl.endsWith('.jpg') ||
        lowerUrl.endsWith('.jpeg') ||
        lowerUrl.endsWith('.png') ||
        lowerUrl.endsWith('.webp') ||
        lowerUrl.endsWith('.gif');

    final isPdf = lowerUrl.endsWith('.pdf');

    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        // Petit label
        Row(
          children: [
            _svg(
              asset: 'assets/icons/paperclip.svg',
              color: AnnoncesScreen.textMuted,
              size: 14,
            ),
            const SizedBox(width: 6),
            const Text(
              'Pièce jointe',
              style: TextStyle(
                color: AnnoncesScreen.textMuted,
                fontSize: 11.5,
                fontWeight: FontWeight.w600,
                letterSpacing: 0.3,
              ),
            ),
          ],
        ),
        const SizedBox(height: 10),

        // Aperçu selon le type
        if (isImage)
          _buildImagePreview(url)
        else if (isPdf)
          _buildPdfPreview(url)
        else
          _buildGenericFilePreview(url),
      ],
    );
  }

  // Aperçu image (vignette cliquable)
  Widget _buildImagePreview(String url) {
    return GestureDetector(
      onTap: () => _ouvrirLien(url),
      child: ClipRRect(
        borderRadius: BorderRadius.circular(14),
        child: Container(
          width: double.infinity,
          constraints: const BoxConstraints(maxHeight: 240),
          decoration: BoxDecoration(
            border: Border.all(color: AnnoncesScreen.border),
            borderRadius: BorderRadius.circular(14),
          ),
          child: Stack(
            children: [
              Image.network(
                url,
                width: double.infinity,
                fit: BoxFit.cover,
                loadingBuilder: (context, child, progress) {
                  if (progress == null) return child;

                  return Container(
                    height: 180,
                    alignment: Alignment.center,
                    color: AnnoncesScreen.primarySoft,
                    child: const SizedBox(
                      width: 26,
                      height: 26,
                      child: CircularProgressIndicator(
                        strokeWidth: 2.5,
                        color: AnnoncesScreen.primary,
                      ),
                    ),
                  );
                },
                errorBuilder: (context, error, stackTrace) {
                  return _buildGenericFilePreview(url);
                },
              ),

              // Overlay "ouvrir"
              Positioned(
                bottom: 10,
                right: 10,
                child: Container(
                  padding: const EdgeInsets.symmetric(
                    horizontal: 10,
                    vertical: 6,
                  ),
                  decoration: BoxDecoration(
                    color: Colors.black.withOpacity(0.65),
                    borderRadius: BorderRadius.circular(20),
                  ),
                  child: Row(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      _svg(
                        asset: 'assets/icons/eye.svg',
                        color: Colors.white,
                        size: 14,
                      ),
                      const SizedBox(width: 6),
                      const Text(
                        'Voir',
                        style: TextStyle(
                          color: Colors.white,
                          fontSize: 11.5,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  // Aperçu PDF (bloc cliquable avec icône)
  Widget _buildPdfPreview(String url) {
    return _buildClickableFile(
      url: url,
      iconAsset: 'assets/icons/file-text.svg',
      iconColor: const Color(0xFFDC2626), // rouge PDF
      iconBg: const Color(0xFFFEF2F2),
      title: 'Document PDF',
      subtitle: 'Appuyez pour ouvrir',
    );
  }

  // Aperçu générique (doc, xls, etc.)
  Widget _buildGenericFilePreview(String url) {
    return _buildClickableFile(
      url: url,
      iconAsset: 'assets/icons/file-text.svg',
      iconColor: AnnoncesScreen.primary,
      iconBg: AnnoncesScreen.primarySoft,
      title: 'Fichier joint',
      subtitle: 'Appuyez pour ouvrir',
    );
  }

  Widget _buildClickableFile({
    required String url,
    required String iconAsset,
    required Color iconColor,
    required Color iconBg,
    required String title,
    required String subtitle,
  }) {
    return Material(
      color: Colors.transparent,
      borderRadius: BorderRadius.circular(14),
      child: InkWell(
        borderRadius: BorderRadius.circular(14),
        onTap: () => _ouvrirLien(url),
        child: Container(
          padding: const EdgeInsets.all(14),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(14),
            border: Border.all(color: AnnoncesScreen.border),
          ),
          child: Row(
            children: [
              Container(
                width: 44,
                height: 44,
                decoration: BoxDecoration(
                  color: iconBg,
                  borderRadius: BorderRadius.circular(11),
                ),
                padding: const EdgeInsets.all(11),
                child: _svg(
                  asset: iconAsset,
                  color: iconColor,
                  size: 22,
                ),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      title,
                      style: const TextStyle(
                        color: AnnoncesScreen.textDark,
                        fontSize: 14,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                    const SizedBox(height: 2),
                    Text(
                      subtitle,
                      style: const TextStyle(
                        color: AnnoncesScreen.textMuted,
                        fontSize: 12,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                  ],
                ),
              ),
              _svg(
                asset: 'assets/icons/chevron_right.svg',
                color: AnnoncesScreen.textMuted,
                size: 20,
              ),
            ],
          ),
        ),
      ),
    );
  }

  // Ouverture du lien (URL externe)
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
          content: Text('Impossible d’ouvrir la pièce jointe.'),
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
    if (value == null || value.toString().isEmpty) {
      return 'Date non disponible';
    }

    final date = DateTime.tryParse(value.toString());

    if (date == null) {
      return 'Date non disponible';
    }

    final localDate = date.toLocal();
    final jour = localDate.day.toString().padLeft(2, '0');
    final mois = localDate.month.toString().padLeft(2, '0');
    final annee = localDate.year;

    return '$jour/$mois/$annee';
  }

  Widget _buildEmptyState() {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.symmetric(
        horizontal: 22,
        vertical: 35,
      ),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: AnnoncesScreen.border),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        children: [
          Container(
            width: 96,
            height: 96,
            decoration: const BoxDecoration(
              color: AnnoncesScreen.primarySoft,
              shape: BoxShape.circle,
            ),
            alignment: Alignment.center,
            child: Container(
              width: 68,
              height: 68,
              decoration: BoxDecoration(
                color: Colors.white,
                shape: BoxShape.circle,
                boxShadow: [
                  BoxShadow(
                    color: AnnoncesScreen.primary.withOpacity(0.15),
                    blurRadius: 12,
                    offset: const Offset(0, 4),
                  ),
                ],
              ),
              padding: const EdgeInsets.all(18),
              child: _svg(
                asset: 'assets/icons/bell_off.svg',
                color: AnnoncesScreen.primary,
                size: 32,
              ),
            ),
          ),
          const SizedBox(height: 22),
          const Text(
            'Aucune annonce pour le moment',
            textAlign: TextAlign.center,
            style: TextStyle(
              color: AnnoncesScreen.textDark,
              fontSize: 18,
              fontWeight: FontWeight.bold,
              letterSpacing: -0.3,
            ),
          ),
          const SizedBox(height: 10),
          const Text(
            'Les prochains communiqués et événements '
            'de l’école apparaîtront ici.',
            textAlign: TextAlign.center,
            style: TextStyle(
              color: AnnoncesScreen.textMuted,
              fontSize: 14,
              height: 1.6,
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }
}
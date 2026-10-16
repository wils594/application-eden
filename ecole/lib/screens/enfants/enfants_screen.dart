import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:ecole_eden/core/theme/app_theme.dart';
import '../../services/api_service.dart';

class EnfantsScreen extends StatefulWidget {
  const EnfantsScreen({super.key});

  @override
  State<EnfantsScreen> createState() => _EnfantsScreenState();
}

class _EnfantsScreenState extends State<EnfantsScreen> {
  List<Map<String, dynamic>> enfants = [];
  bool isLoading = true;
  String? erreur;

  // ═════════════════════════════════════════════
  // 🎨 COULEURS DE MARQUE — BLEU
  // ═════════════════════════════════════════════
  static const Color primaryColor = Color(0xFF2563EB);
  static const Color primaryDark = Color(0xFF1D4ED8);

  /// Palette d'avatars (bleu en premier)
  static const List<List<Color>> _avatarPalette = [
    [Color(0xFF2563EB), Color(0xFF1D4ED8)], // Bleu
    [Color(0xFF7C3AED), Color(0xFF5B21B6)], // Violet
    [Color(0xFFDC2626), Color(0xFFB91C1C)], // Rouge
    [Color(0xFF16A34A), Color(0xFF15803D)], // Vert
    [Color(0xFFDB2777), Color(0xFFBE185D)], // Rose
    [Color(0xFF0891B2), Color(0xFF0E7490)], // Cyan
  ];

  @override
  void initState() {
    super.initState();
    chargerEnfants();
  }

  Future<void> chargerEnfants() async {
    try {
      final response = await ApiService.get('/enfants');
      final donnees = response['data'] as List<dynamic>? ?? [];

      if (!mounted) return;

      setState(() {
        enfants = donnees
            .map((e) => Map<String, dynamic>.from(e as Map))
            .toList();
        isLoading = false;
        erreur = null;
      });
    } catch (e) {
      if (!mounted) return;

      setState(() {
        erreur = e.toString().replaceFirst('Exception: ', '');
        isLoading = false;
      });
    }
  }

  /// Helper : SVG teinté
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

  /// Détecte le genre de l'enfant à partir des champs renvoyés par l'API.
  String _detecterGenre(Map<String, dynamic> enfant) {
    final valeur = (
      enfant['gender'] ??
      enfant['sexe'] ??
      enfant['sex'] ??
      enfant['genre'] ??
      ''
    ).toString().toLowerCase().trim();

    if (valeur == 'f' ||
        valeur == 'female' ||
        valeur == 'fille' ||
        valeur == 'femme' ||
        valeur.startsWith('f')) {
      return 'fille';
    }

    return 'garcon';
  }

  @override
  Widget build(BuildContext context) {
    // ═══════════════════════════════════════════
    // 🎨 COULEURS DYNAMIQUES (light / dark)
    // ═══════════════════════════════════════════
    final textDark = AppTheme.textDark(context);
    final textMuted = AppTheme.textMuted(context);
    final background = Theme.of(context).scaffoldBackgroundColor;
    final cardColor = AppTheme.cardColor(context);
    final border = AppTheme.border(context);
    final primarySoft = AppTheme.primarySoftColor(context);
    final appBarColor =
        Theme.of(context).appBarTheme.backgroundColor ?? cardColor;

    return Scaffold(
      backgroundColor: background,

      appBar: AppBar(
        backgroundColor: appBarColor,
        elevation: 0,
        scrolledUnderElevation: 0,
        centerTitle: false,
        titleSpacing: 20,
        title: Row(
          children: [
            // ── Logo dégradé bleu ──
            Container(
              width: 42,
              height: 42,
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [primaryColor, primaryDark],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),
                borderRadius: BorderRadius.circular(12),
                boxShadow: [
                  BoxShadow(
                    color: primaryColor.withOpacity(0.35),
                    blurRadius: 12,
                    offset: const Offset(0, 4),
                  ),
                ],
              ),
              padding: const EdgeInsets.all(10),
              child: SvgPicture.asset(
                'assets/icons/school.svg',
                colorFilter: const ColorFilter.mode(
                  Colors.white,
                  BlendMode.srcIn,
                ),
              ),
            ),

            const SizedBox(width: 12),

            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisSize: MainAxisSize.min,
              children: [
                Text(
                  'Mes enfants',
                  style: TextStyle(
                    color: textDark,
                    fontSize: 17,
                    fontWeight: FontWeight.bold,
                    letterSpacing: -0.3,
                  ),
                ),
                const SizedBox(height: 2),
                Text(
                  'Suivez leur parcours scolaire',
                  style: TextStyle(
                    color: textMuted,
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
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(20),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              _buildWelcomeCard(),

              const SizedBox(height: 28),

              Text(
                'Liste de mes enfants',
                style: TextStyle(
                  color: textDark,
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                  letterSpacing: -0.3,
                ),
              ),

              const SizedBox(height: 8),

              Text(
                'Retrouvez ici les informations scolaires de vos enfants.',
                style: TextStyle(
                  color: textMuted,
                  fontSize: 14,
                  height: 1.5,
                  fontWeight: FontWeight.w500,
                ),
              ),

              const SizedBox(height: 24),

              _buildChildrenList(context),
            ],
          ),
        ),
      ),
    );
  }

  // ═════════════════════════════════════════════
  // 🎨 Carte bienvenue (dégradé bleu)
  // ═════════════════════════════════════════════
  Widget _buildWelcomeCard() {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          colors: [primaryColor, primaryDark],
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
        ),
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: primaryColor.withOpacity(0.3),
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
              color: Colors.white.withOpacity(0.22),
              shape: BoxShape.circle,
              border: Border.all(
                color: Colors.white.withOpacity(0.35),
                width: 1.5,
              ),
            ),
            padding: const EdgeInsets.all(15),
            child: SvgPicture.asset(
              'assets/icons/family.svg',
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
                  'La réussite de vos enfants',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 17,
                    fontWeight: FontWeight.bold,
                    letterSpacing: -0.3,
                  ),
                ),

                SizedBox(height: 8),

                Text(
                  'Consultez leurs classes, leurs informations et leurs résultats scolaires depuis votre espace parent.',
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

  // ═════════════════════════════════════════════
  // 🎨 État vide
  // ═════════════════════════════════════════════
  Widget _buildEmptyState() {
    final textDark = AppTheme.textDark(context);
    final textMuted = AppTheme.textMuted(context);
    final cardColor = AppTheme.cardColor(context);
    final border = AppTheme.border(context);
    final primarySoft = AppTheme.primarySoftColor(context);

    return Container(
      width: double.infinity,
      padding: const EdgeInsets.symmetric(
        horizontal: 24,
        vertical: 35,
      ),
      decoration: BoxDecoration(
        color: cardColor,
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: border),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.08),
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
            decoration: BoxDecoration(
              color: primarySoft,
              shape: BoxShape.circle,
            ),
            alignment: Alignment.center,
            child: Container(
              width: 68,
              height: 68,
              decoration: BoxDecoration(
                color: cardColor,
                shape: BoxShape.circle,
                boxShadow: [
                  BoxShadow(
                    color: primaryColor.withOpacity(0.2),
                    blurRadius: 12,
                    offset: const Offset(0, 4),
                  ),
                ],
              ),
              padding: const EdgeInsets.all(18),
              child: _svg(
                asset: 'assets/icons/users.svg',
                color: primaryDark,
                size: 32,
              ),
            ),
          ),

          const SizedBox(height: 22),

          Text(
            'Aucun enfant affiché',
            textAlign: TextAlign.center,
            style: TextStyle(
              color: textDark,
              fontSize: 18,
              fontWeight: FontWeight.bold,
              letterSpacing: -0.3,
            ),
          ),

          const SizedBox(height: 10),

          Text(
            'Les enfants associés à votre compte apparaîtront ici dès que l’administration aura enregistré leur dossier.',
            textAlign: TextAlign.center,
            style: TextStyle(
              color: textMuted,
              fontSize: 14,
              height: 1.6,
              fontWeight: FontWeight.w500,
            ),
          ),

          const SizedBox(height: 20),

          Container(
            padding: const EdgeInsets.symmetric(
              horizontal: 14,
              vertical: 10,
            ),
            decoration: BoxDecoration(
              color: primarySoft,
              borderRadius: BorderRadius.circular(10),
              border: Border.all(
                color: primaryColor.withOpacity(0.3),
              ),
            ),
            child: Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                _svg(
                  asset: 'assets/icons/info.svg',
                  color: primaryDark,
                  size: 16,
                ),
                const SizedBox(width: 8),
                Flexible(
                  child: Text(
                    'Données à charger depuis l’API',
                    style: TextStyle(
                      color: primaryDark,
                      fontSize: 12,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  // ═════════════════════════════════════════════
  // 📋 Liste des enfants
  // ═════════════════════════════════════════════
  Widget _buildChildrenList(BuildContext context) {
    final textDark = AppTheme.textDark(context);
    final cardColor = AppTheme.cardColor(context);
    final border = AppTheme.border(context);
    final textMuted = AppTheme.textMuted(context);

    // ── Chargement ──
    if (isLoading) {
      return const Center(
        child: Padding(
          padding: EdgeInsets.all(30),
          child: CircularProgressIndicator(color: primaryColor),
        ),
      );
    }

    // ── Erreur ──
    if (erreur != null) {
      return Center(
        child: Container(
          padding: const EdgeInsets.all(24),
          decoration: BoxDecoration(
            color: cardColor,
            borderRadius: BorderRadius.circular(20),
            border: Border.all(color: border),
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
                erreur!,
                textAlign: TextAlign.center,
                style: TextStyle(
                  color: textDark,
                  fontSize: 14,
                  fontWeight: FontWeight.w500,
                ),
              ),
              const SizedBox(height: 18),
              // Bouton Réessayer bleu
              GestureDetector(
                onTap: () {
                  setState(() {
                    isLoading = true;
                    erreur = null;
                  });
                  chargerEnfants();
                },
                child: Container(
                  padding: const EdgeInsets.symmetric(
                    horizontal: 20,
                    vertical: 11,
                  ),
                  decoration: BoxDecoration(
                    color: primaryColor,
                    borderRadius: BorderRadius.circular(10),
                    boxShadow: [
                      BoxShadow(
                        color: primaryColor.withOpacity(0.3),
                        blurRadius: 12,
                        offset: const Offset(0, 5),
                      ),
                    ],
                  ),
                  child: Row(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      _svg(
                        asset: 'assets/icons/refresh.svg',
                        color: Colors.white,
                        size: 15,
                      ),
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
            ],
          ),
        ),
      );
    }

    // ── Aucun enfant ──
    if (enfants.isEmpty) {
      return _buildEmptyState();
    }

    // ── Liste des enfants ──
    return Column(
      children: List.generate(enfants.length, (index) {
        final enfant = enfants[index];
        final prenom = enfant['first_name']?.toString() ?? '';
        final nom = enfant['last_name']?.toString() ?? '';
        final nomComplet = '$prenom $nom'.trim();
        final classe = enfant['class_name']?.toString() ?? 'Non renseignée';
        final matricule = enfant['matricule']?.toString() ?? 'Non renseigné';

        final genre = _detecterGenre(enfant);
        final avatarColors = _avatarPalette[index % _avatarPalette.length];

        return _FadeSlideIn(
          delay: index * 80,
          child: _buildChildCard(
            context: context,
            nomComplet: nomComplet,
            classe: classe,
            matricule: matricule,
            avatarColors: avatarColors,
            avatarAsset: genre == 'fille'
                ? 'assets/icons/girl.svg'
                : 'assets/icons/boy.svg',
          ),
        );
      }),
    );
  }

  // ═════════════════════════════════════════════
  // 👶 Carte enfant
  // ═════════════════════════════════════════════
  Widget _buildChildCard({
    required BuildContext context,
    required String nomComplet,
    required String classe,
    required String matricule,
    required List<Color> avatarColors,
    required String avatarAsset,
  }) {
    final textDark = AppTheme.textDark(context);
    final textMuted = AppTheme.textMuted(context);
    final cardColor = AppTheme.cardColor(context);
    final border = AppTheme.border(context);
    final primarySoft = AppTheme.primarySoftColor(context);

    return _PressableCard(
      accentColor: avatarColors[0],
      cardColor: cardColor,
      borderColor: border,
      onTap: () {
        // Action silencieuse pour l'instant
      },
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Row(
          children: [
            // ── Avatar (avec bordure + ombre colorée) ──
            Container(
              width: 64,
              height: 64,
              decoration: BoxDecoration(
                gradient: LinearGradient(
                  colors: avatarColors,
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),
                shape: BoxShape.circle,
                border: Border.all(color: cardColor, width: 3),
                boxShadow: [
                  BoxShadow(
                    color: avatarColors[0].withOpacity(0.35),
                    blurRadius: 12,
                    offset: const Offset(0, 6),
                  ),
                ],
              ),
              padding: const EdgeInsets.all(14),
              child: SvgPicture.asset(
                avatarAsset,
                colorFilter: const ColorFilter.mode(
                  Colors.white,
                  BlendMode.srcIn,
                ),
              ),
            ),

            const SizedBox(width: 16),

            // ── Infos ──
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisSize: MainAxisSize.min,
                children: [
                  // Nom
                  Text(
                    nomComplet.isEmpty ? 'Nom non renseigné' : nomComplet,
                    style: TextStyle(
                      color: textDark,
                      fontSize: 16,
                      fontWeight: FontWeight.bold,
                      letterSpacing: -0.2,
                    ),
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                  ),

                  const SizedBox(height: 8),

                  // Badge classe (bleu)
                  Container(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 9,
                      vertical: 4,
                    ),
                    decoration: BoxDecoration(
                      color: primarySoft,
                      borderRadius: BorderRadius.circular(6),
                      border: Border.all(
                        color: primaryColor.withOpacity(0.3),
                      ),
                    ),
                    child: Text(
                      classe,
                      style: const TextStyle(
                        color: primaryDark,
                        fontSize: 11.5,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ),

                  const SizedBox(height: 8),

                  // Matricule avec icône
                  Row(
                    children: [
                      _svg(
                        asset: 'assets/icons/badge.svg',
                        color: textMuted,
                        size: 13,
                      ),
                      const SizedBox(width: 5),
                      Expanded(
                        child: Text(
                          matricule,
                          style: TextStyle(
                            color: textMuted,
                            fontSize: 12,
                            fontWeight: FontWeight.w500,
                          ),
                          maxLines: 1,
                          overflow: TextOverflow.ellipsis,
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),

            const SizedBox(width: 8),

            // ── Chevron ──
            _svg(
              asset: 'assets/icons/chevron_right.svg',
              color: textMuted,
              size: 20,
            ),
          ],
        ),
      ),
    );
  }
}

// ═════════════════════════════════════════════════
// 🎨 CARTE PRESSABLE (hover + press)
// ═════════════════════════════════════════════════

class _PressableCard extends StatefulWidget {
  final Widget child;
  final Color accentColor;
  final Color cardColor;
  final Color borderColor;
  final VoidCallback onTap;

  const _PressableCard({
    required this.child,
    required this.accentColor,
    required this.cardColor,
    required this.borderColor,
    required this.onTap,
  });

  @override
  State<_PressableCard> createState() => _PressableCardState();
}

class _PressableCardState extends State<_PressableCard> {
  bool _isHovered = false;
  bool _isPressed = false;

  @override
  Widget build(BuildContext context) {
    final active = _isHovered || _isPressed;

    return MouseRegion(
      onEnter: (_) => setState(() => _isHovered = true),
      onExit: (_) => setState(() => _isHovered = false),
      cursor: SystemMouseCursors.click,
      child: GestureDetector(
        onTapDown: (_) => setState(() => _isPressed = true),
        onTapUp: (_) => setState(() => _isPressed = false),
        onTapCancel: () => setState(() => _isPressed = false),
        onTap: widget.onTap,
        child: AnimatedScale(
          scale: _isPressed ? 0.98 : (_isHovered ? 1.015 : 1.0),
          duration: const Duration(milliseconds: 200),
          curve: Curves.easeOutCubic,
          child: AnimatedContainer(
            duration: const Duration(milliseconds: 200),
            curve: Curves.easeOutCubic,
            margin: const EdgeInsets.only(bottom: 14),
            decoration: BoxDecoration(
              color: active
                  ? Color.lerp(widget.cardColor, widget.accentColor, 0.05)
                  : widget.cardColor,
              borderRadius: BorderRadius.circular(20),
              border: Border.all(
                color: active
                    ? widget.accentColor.withOpacity(0.5)
                    : widget.borderColor,
                width: active ? 1.5 : 1.0,
              ),
              boxShadow: [
                BoxShadow(
                  color: widget.accentColor
                      .withOpacity(active ? 0.2 : 0.08),
                  blurRadius: active ? 20 : 12,
                  offset: Offset(0, active ? 8 : 4),
                ),
              ],
            ),
            child: widget.child,
          ),
        ),
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
      duration: const Duration(milliseconds: 500),
    );

    _opacity = CurvedAnimation(parent: _controller, curve: Curves.easeOut);

    _slide = Tween<Offset>(
      begin: const Offset(0, 0.15),
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
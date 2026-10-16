import 'dart:math' as math;
import 'dart:ui';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:ecole_eden/core/theme/app_theme.dart';

class HomeScreen extends StatefulWidget {
  final String parentName;

  const HomeScreen({
    super.key,
    this.parentName = 'Parent',
  });

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen>
    with TickerProviderStateMixin {
  int _selectedIndex = 0;

  // ═════════════════════════════════════════════
  // 🎨 COULEURS DE MARQUE — BLEU
  // ═════════════════════════════════════════════
  static const Color primary = Color(0xFF2563EB);
  static const Color primaryDark = Color(0xFF1D4ED8);
  static const Color accent = Color(0xFFBFDBFE);

  final List<_MenuItem> _menuItems = const [
    _MenuItem(title: 'Accueil', iconAsset: 'assets/icons/home.svg'),
    _MenuItem(title: 'Enfants', iconAsset: 'assets/icons/family.svg'),
    _MenuItem(title: 'Bulletins', iconAsset: 'assets/icons/document.svg'),
    _MenuItem(title: 'Annonces', iconAsset: 'assets/icons/megaphone.svg'),
    _MenuItem(title: 'Messages', iconAsset: 'assets/icons/chat.svg'),
    _MenuItem(title: 'Profil', iconAsset: 'assets/icons/user.svg'),
    _MenuItem(title: 'Réglages', iconAsset: 'assets/icons/settings.svg'),
  ];

  Widget _svg(
    String asset, {
    Color? color,
    double size = 22,
  }) {
    return SvgPicture.asset(
      asset,
      width: size,
      height: size,
      colorFilter: ColorFilter.mode(
        color ?? Colors.black,
        BlendMode.srcIn,
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final textDark = AppTheme.textDark(context);
    final textMuted = AppTheme.textMuted(context);
    final textBody = AppTheme.textMuted(context);
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
        automaticallyImplyLeading: false,
        titleSpacing: 20,
        title: Row(
          children: [
            _GlowingLogo(
              svgBuilder: (color, size) => _svg(
                'assets/icons/school.svg',
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
                  'École Eden',
                  style: TextStyle(
                    color: textDark,
                    fontSize: 17,
                    fontWeight: FontWeight.bold,
                    letterSpacing: -0.3,
                  ),
                ),
                Text(
                  'Espace parent',
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
        actions: [
          Padding(
            padding: const EdgeInsets.only(right: 12),
            child: _AnimatedBellButton(
              svgBuilder: (color, size) => _svg(
                'assets/icons/bell.svg',
                color: color,
                size: size,
              ),
              onTap: _showNotifications,
              iconColor: textDark,
            ),
          ),
        ],
      ),

      body: AnimatedSwitcher(
        duration: const Duration(milliseconds: 400),
        switchInCurve: Curves.easeOutCubic,
        switchOutCurve: Curves.easeInCubic,
        transitionBuilder: (child, animation) {
          final offset = Tween<Offset>(
            begin: const Offset(0, 0.08),
            end: Offset.zero,
          ).animate(animation);

          return FadeTransition(
            opacity: animation,
            child: SlideTransition(position: offset, child: child),
          );
        },
        child: KeyedSubtree(
          key: ValueKey(_selectedIndex),
          child: _buildCurrentPage(
            textDark: textDark,
            textMuted: textMuted,
            textBody: textBody,
            cardColor: cardColor,
            border: border,
            primarySoft: primarySoft,
          ),
        ),
      ),

      bottomNavigationBar: _buildBottomMenu(
        textDark: textDark,
        textMuted: textMuted,
        cardColor: cardColor,
        border: border,
        primarySoft: primarySoft,
      ),
    );
  }

  Widget _buildCurrentPage({
    required Color textDark,
    required Color textMuted,
    required Color textBody,
    required Color cardColor,
    required Color border,
    required Color primarySoft,
  }) {
    if (_selectedIndex == 0) {
      return _buildHomePage(
        textDark: textDark,
        textMuted: textMuted,
        textBody: textBody,
        cardColor: cardColor,
        border: border,
        primarySoft: primarySoft,
      );
    }

    return _buildComingSoonPage(
      _menuItems[_selectedIndex].title,
      _menuItems[_selectedIndex].iconAsset,
      textDark: textDark,
      textMuted: textMuted,
      primarySoft: primarySoft,
    );
  }

  Widget _buildHomePage({
    required Color textDark,
    required Color textMuted,
    required Color textBody,
    required Color cardColor,
    required Color border,
    required Color primarySoft,
  }) {
    return SafeArea(
      child: SingleChildScrollView(
        padding: const EdgeInsets.fromLTRB(20, 20, 20, 25),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _FadeSlideIn(
              delay: 0,
              child: Text(
                'Bonjour, ${widget.parentName} !',
                style: TextStyle(
                  color: textDark,
                  fontSize: 27,
                  fontWeight: FontWeight.bold,
                  letterSpacing: -0.5,
                ),
              ),
            ),

            const SizedBox(height: 8),

            _FadeSlideIn(
              delay: 80,
              child: Text(
                'Ravi de vous revoir dans votre espace parent.',
                style: TextStyle(
                  color: textBody,
                  fontSize: 16,
                  height: 1.4,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ),

            const SizedBox(height: 4),

            _FadeSlideIn(
              delay: 160,
              child: Text(
                'Nous sommes là pour vous accompagner et vous permettre de suivre facilement la vie scolaire de vos enfants.',
                style: TextStyle(
                  color: textMuted,
                  fontSize: 14,
                  height: 1.5,
                ),
              ),
            ),

            const SizedBox(height: 25),

            _FadeSlideIn(
              delay: 240,
              child: _AnimatedWelcomeCard(
                svgBuilder: (color, size) => _svg(
                  'assets/icons/school.svg',
                  color: color,
                  size: size,
                ),
              ),
            ),

            const SizedBox(height: 28),

            _FadeSlideIn(
              delay: 320,
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Text(
                    'Votre suivi scolaire',
                    style: TextStyle(
                      color: textDark,
                      fontSize: 19,
                      fontWeight: FontWeight.bold,
                      letterSpacing: -0.3,
                    ),
                  ),
                  Container(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 10,
                      vertical: 4,
                    ),
                    decoration: BoxDecoration(
                      color: primarySoft,
                      borderRadius: BorderRadius.circular(20),
                      border: Border.all(
                        color: primary.withOpacity(0.3),
                      ),
                    ),
                    child: const _AnimatedCounter(
                      value: 4,
                      style: TextStyle(
                        color: primaryDark,
                        fontSize: 12,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ),
                ],
              ),
            ),

            const SizedBox(height: 15),

            Row(
              children: [
                Expanded(
                  child: _FadeSlideIn(
                    delay: 400,
                    child: _HoverableInfoCard(
                      iconAsset: 'assets/icons/family.svg',
                      title: 'Mes enfants',
                      subtitle: 'Suivre leur scolarité',
                      accentColor: primary,
                      svgBuilder: _svg,
                      onTap: () {},
                      cardColor: cardColor,
                      textDark: textDark,
                      textMuted: textMuted,
                      borderColor: border,
                    ),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: _FadeSlideIn(
                    delay: 460,
                    child: _HoverableInfoCard(
                      iconAsset: 'assets/icons/document.svg',
                      title: 'Bulletins',
                      subtitle: 'Consulter les résultats',
                      accentColor: const Color(0xFFF59E0B),
                      svgBuilder: _svg,
                      onTap: () {},
                      cardColor: cardColor,
                      textDark: textDark,
                      textMuted: textMuted,
                      borderColor: border,
                    ),
                  ),
                ),
              ],
            ),

            const SizedBox(height: 12),

            Row(
              children: [
                Expanded(
                  child: _FadeSlideIn(
                    delay: 520,
                    child: _HoverableInfoCard(
                      iconAsset: 'assets/icons/megaphone.svg',
                      title: 'Annonces',
                      subtitle: 'Actualités de l’école',
                      accentColor: const Color(0xFF8B5CF6),
                      svgBuilder: _svg,
                      onTap: () {},
                      cardColor: cardColor,
                      textDark: textDark,
                      textMuted: textMuted,
                      borderColor: border,
                    ),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: _FadeSlideIn(
                    delay: 580,
                    child: _HoverableInfoCard(
                      iconAsset: 'assets/icons/chat.svg',
                      title: 'Messages',
                      subtitle: 'Échanger avec l’école',
                      accentColor: const Color(0xFF10B981),
                      svgBuilder: _svg,
                      onTap: () {},
                      cardColor: cardColor,
                      textDark: textDark,
                      textMuted: textMuted,
                      borderColor: border,
                    ),
                  ),
                ),
              ],
            ),

            const SizedBox(height: 30),

            // 🔮 Bandeau info glassmorphism
            _FadeSlideIn(
              delay: 640,
              child: ClipRRect(
                borderRadius: BorderRadius.circular(16),
                child: BackdropFilter(
                  filter: ImageFilter.blur(sigmaX: 10, sigmaY: 10),
                  child: Container(
                    width: double.infinity,
                    padding: const EdgeInsets.all(18),
                    decoration: BoxDecoration(
                      color: cardColor.withOpacity(0.7),
                      borderRadius: BorderRadius.circular(16),
                      border: Border.all(
                        color: primary.withOpacity(0.2),
                        width: 1.5,
                      ),
                      boxShadow: [
                        BoxShadow(
                          color: primary.withOpacity(0.08),
                          blurRadius: 20,
                          offset: const Offset(0, 8),
                        ),
                      ],
                    ),
                    child: Row(
                      children: [
                        Container(
                          width: 42,
                          height: 42,
                          decoration: BoxDecoration(
                            gradient: LinearGradient(
                              colors: [
                                primary.withOpacity(0.2),
                                primary.withOpacity(0.1),
                              ],
                            ),
                            borderRadius: BorderRadius.circular(12),
                          ),
                          padding: const EdgeInsets.all(10),
                          child: _svg(
                            'assets/icons/info.svg',
                            color: primaryDark,
                            size: 22,
                          ),
                        ),
                        const SizedBox(width: 13),
                        Expanded(
                          child: Text(
                            'Les informations importantes de l’école apparaîtront ici.',
                            style: TextStyle(
                              color: textBody,
                              fontSize: 13,
                              height: 1.4,
                              fontWeight: FontWeight.w500,
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildComingSoonPage(
    String title,
    String iconAsset, {
    required Color textDark,
    required Color textMuted,
    required Color primarySoft,
  }) {
    return Center(
      child: Padding(
        padding: const EdgeInsets.all(30),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            TweenAnimationBuilder<double>(
              tween: Tween(begin: 0.0, end: 1.0),
              duration: const Duration(milliseconds: 700),
              curve: Curves.elasticOut,
              builder: (context, value, child) {
                return Transform.scale(
                  scale: value,
                  child: Transform.rotate(
                    angle: (1 - value) * 0.5,
                    child: child,
                  ),
                );
              },
              child: Container(
                width: 88,
                height: 88,
                decoration: BoxDecoration(
                  color: primarySoft,
                  borderRadius: BorderRadius.circular(26),
                  border: Border.all(
                    color: primary.withOpacity(0.3),
                  ),
                  boxShadow: [
                    BoxShadow(
                      color: primary.withOpacity(0.2),
                      blurRadius: 24,
                      offset: const Offset(0, 10),
                    ),
                  ],
                ),
                padding: const EdgeInsets.all(24),
                child: _svg(iconAsset, color: primaryDark, size: 40),
              ),
            ),
            const SizedBox(height: 22),
            Text(
              title,
              style: TextStyle(
                color: textDark,
                fontSize: 22,
                fontWeight: FontWeight.bold,
                letterSpacing: -0.3,
              ),
            ),
            const SizedBox(height: 8),
            Text(
              'Cette fonctionnalité sera bientôt disponible.',
              textAlign: TextAlign.center,
              style: TextStyle(
                color: textMuted,
                fontSize: 14,
                fontWeight: FontWeight.w500,
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildBottomMenu({
    required Color textDark,
    required Color textMuted,
    required Color cardColor,
    required Color border,
    required Color primarySoft,
  }) {
    return Container(
      padding: const EdgeInsets.only(top: 8, bottom: 8),
      decoration: BoxDecoration(
        color: cardColor,
        border: Border(top: BorderSide(color: border)),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.08),
            blurRadius: 10,
            offset: const Offset(0, -3),
          ),
        ],
      ),
      child: SafeArea(
        top: false,
        child: LayoutBuilder(
          builder: (context, constraints) {
            final itemWidth = (constraints.maxWidth - 16) / 4;

            return Wrap(
              alignment: WrapAlignment.center,
              runAlignment: WrapAlignment.center,
              spacing: 0,
              runSpacing: 5,
              children: List.generate(
                _menuItems.length,
                (index) {
                  final item = _menuItems[index];
                  final selected = _selectedIndex == index;

                  return SizedBox(
                    width: itemWidth,
                    height: 54,
                    child: _AnimatedMenuItem(
                      selected: selected,
                      title: item.title,
                      textDark: textDark,
                      textMuted: textMuted,
                      primarySoft: primarySoft,
                      svgBuilder: (color, size) =>
                          _svg(item.iconAsset, color: color, size: size),
                      onTap: () {
                        switch (index) {
                          case 0:
                            setState(() => _selectedIndex = 0);
                            break;
                          case 1:
                            Navigator.pushNamed(context, '/enfants');
                            break;
                          case 2:
                            Navigator.pushNamed(context, '/bulletins');
                            break;
                          case 3:
                            Navigator.pushNamed(context, '/annonces');
                            break;
                          case 4:
                            Navigator.pushNamed(context, '/chat');
                            break;
                          case 5:
                            Navigator.pushNamed(context, '/profil');
                            break;
                          case 6:
                            Navigator.pushNamed(context, '/reglages');
                            break;
                        }
                      },
                    ),
                  );
                },
              ),
            );
          },
        ),
      ),
    );
  }

  void _showNotifications() {
    final cardColor = AppTheme.cardColor(context);
    final textDark = AppTheme.textDark(context);
    final textMuted = AppTheme.textMuted(context);
    final primarySoft = AppTheme.primarySoftColor(context);

    showModalBottomSheet(
      context: context,
      backgroundColor: cardColor,
      showDragHandle: true,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
      ),
      builder: (context) {
        return Padding(
          padding: const EdgeInsets.fromLTRB(20, 10, 20, 30),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                children: [
                  TweenAnimationBuilder<double>(
                    tween: Tween(begin: 0.0, end: 1.0),
                    duration: const Duration(milliseconds: 400),
                    curve: Curves.easeOutBack,
                    builder: (context, value, child) {
                      return Transform.rotate(
                        angle: (1 - value) * 0.5,
                        child: Transform.scale(scale: value, child: child),
                      );
                    },
                    child: Container(
                      width: 40,
                      height: 40,
                      decoration: BoxDecoration(
                        color: primarySoft,
                        borderRadius: BorderRadius.circular(12),
                        border: Border.all(
                          color: primary.withOpacity(0.3),
                        ),
                      ),
                      padding: const EdgeInsets.all(10),
                      child: _svg(
                        'assets/icons/bell.svg',
                        color: primaryDark,
                        size: 20,
                      ),
                    ),
                  ),
                  const SizedBox(width: 12),
                  Text(
                    'Notifications',
                    style: TextStyle(
                      fontSize: 20,
                      fontWeight: FontWeight.bold,
                      color: textDark,
                      letterSpacing: -0.3,
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 24),
              Center(
                child: Column(
                  children: [
                    Container(
                      width: 64,
                      height: 64,
                      decoration: BoxDecoration(
                        color: textMuted.withOpacity(0.1),
                        shape: BoxShape.circle,
                      ),
                      padding: const EdgeInsets.all(20),
                      child: _svg(
                        'assets/icons/bell_off.svg',
                        color: textMuted,
                        size: 24,
                      ),
                    ),
                    const SizedBox(height: 14),
                    Text(
                      'Aucune nouvelle notification.',
                      style: TextStyle(
                        color: textMuted,
                        fontSize: 14,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
        );
      },
    );
  }
}

// ═════════════════════════════════════════════════
// 🌟 LOGO AVEC GLOW PULSANT (BLEU)
// ═════════════════════════════════════════════════

class _GlowingLogo extends StatefulWidget {
  final Widget Function(Color color, double size) svgBuilder;

  const _GlowingLogo({required this.svgBuilder});

  @override
  State<_GlowingLogo> createState() => _GlowingLogoState();
}

class _GlowingLogoState extends State<_GlowingLogo>
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
      builder: (context, value, child) {
        return Transform.scale(scale: value, child: child);
      },
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
                  _HomeScreenState.primary,
                  _HomeScreenState.primaryDark,
                ],
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
              ),
              borderRadius: BorderRadius.circular(12),
              boxShadow: [
                BoxShadow(
                  color: _HomeScreenState.primary.withOpacity(glow),
                  blurRadius: 16 + (_controller.value * 12),
                  spreadRadius: _controller.value * 2,
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
// 🌈 CARTE BIENVENUE ANIMÉE (BLEU)
// ═════════════════════════════════════════════════

class _AnimatedWelcomeCard extends StatefulWidget {
  final Widget Function(Color color, double size) svgBuilder;

  const _AnimatedWelcomeCard({required this.svgBuilder});

  @override
  State<_AnimatedWelcomeCard> createState() => _AnimatedWelcomeCardState();
}

class _AnimatedWelcomeCardState extends State<_AnimatedWelcomeCard>
    with TickerProviderStateMixin {
  late AnimationController _gradientController;
  late AnimationController _shimmerController;

  @override
  void initState() {
    super.initState();

    _gradientController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 4000),
    )..repeat();

    _shimmerController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 2500),
    )..repeat();
  }

  @override
  void dispose() {
    _gradientController.dispose();
    _shimmerController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return AnimatedBuilder(
      animation: _gradientController,
      builder: (context, child) {
        return Container(
          width: double.infinity,
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(20),
            boxShadow: [
              BoxShadow(
                color: _HomeScreenState.primary.withOpacity(0.35),
                blurRadius: 25,
                offset: const Offset(0, 12),
              ),
            ],
          ),
          child: ClipRRect(
            borderRadius: BorderRadius.circular(20),
            child: Stack(
              children: [
                Positioned.fill(
                  child: AnimatedBuilder(
                    animation: _gradientController,
                    builder: (context, _) {
                      final t = _gradientController.value;
                      return Container(
                        decoration: BoxDecoration(
                          gradient: LinearGradient(
                            colors: const [
                              Color(0xFF2563EB), // Bleu
                              Color(0xFF1D4ED8), // Bleu foncé
                              Color(0xFF1E40AF), // Bleu nuit
                              Color(0xFF2563EB), // Retour bleu
                            ],
                            begin: Alignment(
                              math.cos(t * 2 * math.pi),
                              math.sin(t * 2 * math.pi),
                            ),
                            end: Alignment(
                              -math.cos(t * 2 * math.pi),
                              -math.sin(t * 2 * math.pi),
                            ),
                          ),
                        ),
                      );
                    },
                  ),
                ),

                ..._buildParticles(),

                Padding(
                  padding: const EdgeInsets.all(22),
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
                        child: widget.svgBuilder(Colors.white, 28),
                      ),
                      const SizedBox(width: 16),
                      const Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              'Votre espace scolaire',
                              style: TextStyle(
                                color: Colors.white,
                                fontSize: 18,
                                fontWeight: FontWeight.bold,
                                letterSpacing: -0.3,
                              ),
                            ),
                            SizedBox(height: 6),
                            Text(
                              'Retrouvez facilement les informations importantes concernant vos enfants.',
                              style: TextStyle(
                                color: Colors.white70,
                                fontSize: 13,
                                height: 1.4,
                              ),
                            ),
                          ],
                        ),
                      ),
                    ],
                  ),
                ),

                Positioned.fill(
                  child: IgnorePointer(
                    child: AnimatedBuilder(
                      animation: _shimmerController,
                      builder: (context, _) {
                        return Container(
                          decoration: BoxDecoration(
                            gradient: LinearGradient(
                              begin: Alignment(
                                -1 + _shimmerController.value * 2,
                                -0.3,
                              ),
                              end: Alignment(
                                _shimmerController.value * 2,
                                0.3,
                              ),
                              colors: [
                                Colors.white.withOpacity(0),
                                Colors.white.withOpacity(0.3),
                                Colors.white.withOpacity(0),
                              ],
                              stops: const [0.35, 0.5, 0.65],
                            ),
                          ),
                        );
                      },
                    ),
                  ),
                ),
              ],
            ),
          ),
        );
      },
    );
  }

  List<Widget> _buildParticles() {
    final particles = <Widget>[];
    final rng = math.Random(42);

    for (int i = 0; i < 8; i++) {
      final startX = rng.nextDouble();
      final startY = rng.nextDouble();
      final size = 2.0 + rng.nextDouble() * 3;
      final delay = rng.nextDouble();

      particles.add(
        Positioned(
          left: startX * 300,
          top: startY * 120,
          child: _FloatingParticle(
            size: size,
            delay: delay,
          ),
        ),
      );
    }

    return particles;
  }
}

class _FloatingParticle extends StatefulWidget {
  final double size;
  final double delay;

  const _FloatingParticle({
    required this.size,
    required this.delay,
  });

  @override
  State<_FloatingParticle> createState() => _FloatingParticleState();
}

class _FloatingParticleState extends State<_FloatingParticle>
    with SingleTickerProviderStateMixin {
  late AnimationController _controller;

  @override
  void initState() {
    super.initState();
    _controller = AnimationController(
      vsync: this,
      duration: Duration(milliseconds: 3000 + (widget.delay * 2000).toInt()),
    );

    Future.delayed(Duration(milliseconds: (widget.delay * 1000).toInt()), () {
      if (mounted) _controller.repeat();
    });
  }

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return AnimatedBuilder(
      animation: _controller,
      builder: (context, child) {
        final t = _controller.value;
        return Transform.translate(
          offset: Offset(
            math.sin(t * 2 * math.pi) * 15,
            -t * 60,
          ),
          child: Opacity(
            opacity: (1 - t).clamp(0.0, 1.0) * 0.7,
            child: Container(
              width: widget.size,
              height: widget.size,
              decoration: BoxDecoration(
                color: Colors.white,
                shape: BoxShape.circle,
                boxShadow: [
                  BoxShadow(
                    color: Colors.white.withOpacity(0.8),
                    blurRadius: 6,
                    spreadRadius: 1,
                  ),
                ],
              ),
            ),
          ),
        );
      },
    );
  }
}

// ═════════════════════════════════════════════════
// 📊 COMPTEUR ANIMÉ
// ═════════════════════════════════════════════════

class _AnimatedCounter extends StatelessWidget {
  final int value;
  final TextStyle style;

  const _AnimatedCounter({
    required this.value,
    required this.style,
  });

  @override
  Widget build(BuildContext context) {
    return TweenAnimationBuilder<int>(
      tween: IntTween(begin: 0, end: value),
      duration: const Duration(milliseconds: 900),
      curve: Curves.easeOutCubic,
      builder: (context, val, _) {
        return Text('$val', style: style);
      },
    );
  }
}

// ═════════════════════════════════════════════════
// 🎨 CARTE INFO AVEC HOVER MAGNÉTIQUE + RIPPLE
// ═════════════════════════════════════════════════

class _HoverableInfoCard extends StatefulWidget {
  final String iconAsset;
  final String title;
  final String subtitle;
  final Color accentColor;
  final VoidCallback onTap;
  final Widget Function(String asset, {Color? color, double size}) svgBuilder;
  final Color cardColor;
  final Color textDark;
  final Color textMuted;
  final Color borderColor;

  const _HoverableInfoCard({
    required this.iconAsset,
    required this.title,
    required this.subtitle,
    required this.accentColor,
    required this.onTap,
    required this.svgBuilder,
    required this.cardColor,
    required this.textDark,
    required this.textMuted,
    required this.borderColor,
  });

  @override
  State<_HoverableInfoCard> createState() => _HoverableInfoCardState();
}

class _HoverableInfoCardState extends State<_HoverableInfoCard>
    with SingleTickerProviderStateMixin {
  bool _isHovered = false;
  bool _isPressed = false;
  Offset _mousePosition = Offset.zero;

  late AnimationController _rippleController;
  Offset _ripplePosition = Offset.zero;

  @override
  void initState() {
    super.initState();
    _rippleController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 600),
    );
  }

  @override
  void dispose() {
    _rippleController.dispose();
    super.dispose();
  }

  void _handleTapDown(TapDownDetails details) {
    setState(() {
      _isPressed = true;
      _ripplePosition = details.localPosition;
    });
    _rippleController.forward(from: 0);
  }

  @override
  Widget build(BuildContext context) {
    final active = _isHovered || _isPressed;

    final tiltX = _isHovered
        ? ((_mousePosition.dx / 200) - 0.5) * 0.06
        : 0.0;
    final tiltY = _isHovered
        ? ((_mousePosition.dy / 200) - 0.5) * 0.06
        : 0.0;

    return MouseRegion(
      onEnter: (_) => setState(() => _isHovered = true),
      onExit: (_) => setState(() => _isHovered = false),
      onHover: (event) {
        setState(() {
          _mousePosition = event.localPosition;
        });
      },
      cursor: SystemMouseCursors.click,
      child: GestureDetector(
        onTapDown: _handleTapDown,
        onTapUp: (_) => setState(() => _isPressed = false),
        onTapCancel: () => setState(() => _isPressed = false),
        onTap: widget.onTap,
        child: AnimatedScale(
          scale: _isPressed ? 0.96 : (_isHovered ? 1.04 : 1.0),
          duration: const Duration(milliseconds: 200),
          curve: Curves.easeOutCubic,
          child: Transform(
            transform: Matrix4.identity()
              ..setEntry(3, 2, 0.001)
              ..rotateX(tiltY)
              ..rotateY(tiltX),
            alignment: Alignment.center,
            child: AnimatedContainer(
              duration: const Duration(milliseconds: 250),
              curve: Curves.easeOutCubic,
              padding: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: active
                    ? Color.lerp(
                        widget.cardColor,
                        widget.accentColor,
                        0.08,
                      )
                    : widget.cardColor,
                borderRadius: BorderRadius.circular(16),
                border: Border.all(
                  color: active
                      ? widget.accentColor
                      : widget.borderColor,
                  width: active ? 1.5 : 1.0,
                ),
                boxShadow: [
                  BoxShadow(
                    color: widget.accentColor
                        .withOpacity(active ? 0.28 : 0.08),
                    blurRadius: active ? 28 : 12,
                    offset: Offset(0, active ? 12 : 6),
                    spreadRadius: active ? 1 : 0,
                  ),
                ],
              ),
              child: Stack(
                children: [
                  Positioned.fill(
                    child: IgnorePointer(
                      child: AnimatedBuilder(
                        animation: _rippleController,
                        builder: (context, _) {
                          if (_rippleController.value == 0) {
                            return const SizedBox.shrink();
                          }
                          final size = _rippleController.value * 250;
                          return ClipRRect(
                            borderRadius: BorderRadius.circular(16),
                            child: Stack(
                              children: [
                                Positioned(
                                  left: _ripplePosition.dx - size / 2,
                                  top: _ripplePosition.dy - size / 2,
                                  child: Container(
                                    width: size,
                                    height: size,
                                    decoration: BoxDecoration(
                                      shape: BoxShape.circle,
                                      color: widget.accentColor.withOpacity(
                                        (1 - _rippleController.value) * 0.3,
                                      ),
                                    ),
                                  ),
                                ),
                              ],
                            ),
                          );
                        },
                      ),
                    ),
                  ),

                  Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          AnimatedScale(
                            scale: active ? 1.1 : 1.0,
                            duration: const Duration(milliseconds: 250),
                            curve: Curves.easeOutBack,
                            child: AnimatedContainer(
                              duration: const Duration(milliseconds: 250),
                              width: 44,
                              height: 44,
                              decoration: BoxDecoration(
                                color: widget.accentColor
                                    .withOpacity(active ? 0.25 : 0.15),
                                borderRadius: BorderRadius.circular(12),
                                boxShadow: active
                                    ? [
                                        BoxShadow(
                                          color: widget.accentColor
                                              .withOpacity(0.3),
                                          blurRadius: 12,
                                          spreadRadius: 1,
                                        ),
                                      ]
                                    : null,
                              ),
                              padding: const EdgeInsets.all(11),
                              child: widget.svgBuilder(
                                widget.iconAsset,
                                color: widget.accentColor,
                                size: 22,
                              ),
                            ),
                          ),
                          AnimatedOpacity(
                            opacity: active ? 1.0 : 0.0,
                            duration: const Duration(milliseconds: 250),
                            child: AnimatedSlide(
                              offset: active
                                  ? Offset.zero
                                  : const Offset(-0.4, 0.4),
                              duration: const Duration(milliseconds: 250),
                              curve: Curves.easeOutCubic,
                              child: Container(
                                width: 26,
                                height: 26,
                                decoration: BoxDecoration(
                                  color:
                                      widget.accentColor.withOpacity(0.2),
                                  borderRadius: BorderRadius.circular(8),
                                ),
                                padding: const EdgeInsets.all(6),
                                child: widget.svgBuilder(
                                  'assets/icons/arrow_right.svg',
                                  color: widget.accentColor,
                                  size: 14,
                                ),
                              ),
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 13),
                      AnimatedDefaultTextStyle(
                        duration: const Duration(milliseconds: 250),
                        style: TextStyle(
                          color: active
                              ? widget.accentColor
                              : widget.textDark,
                          fontSize: 14,
                          fontWeight: FontWeight.bold,
                          letterSpacing: -0.2,
                        ),
                        child: Text(widget.title),
                      ),
                      const SizedBox(height: 4),
                      Text(
                        widget.subtitle,
                        style: TextStyle(
                          color: widget.textMuted,
                          fontSize: 11,
                          height: 1.3,
                          fontWeight: FontWeight.w500,
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}

// ═════════════════════════════════════════════════
// ✨ FADE SLIDE IN
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
  late Animation<double> _rotation;

  @override
  void initState() {
    super.initState();
    _controller = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 600),
    );

    _opacity = CurvedAnimation(parent: _controller, curve: Curves.easeOut);

    _slide = Tween<Offset>(
      begin: const Offset(0, 0.2),
      end: Offset.zero,
    ).animate(
      CurvedAnimation(parent: _controller, curve: Curves.easeOutCubic),
    );

    _rotation = Tween<double>(
      begin: 0.03,
      end: 0.0,
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
    return AnimatedBuilder(
      animation: _controller,
      builder: (context, child) {
        return Opacity(
          opacity: _opacity.value,
          child: Transform.translate(
            offset: _slide.value * 60,
            child: Transform.rotate(
              angle: _rotation.value,
              child: child,
            ),
          ),
        );
      },
      child: widget.child,
    );
  }
}

// ═════════════════════════════════════════════════
// 📱 BOTTOM MENU ITEM ANIMÉ
// ═════════════════════════════════════════════════

class _AnimatedMenuItem extends StatefulWidget {
  final bool selected;
  final String title;
  final VoidCallback onTap;
  final Widget Function(Color color, double size) svgBuilder;
  final Color textDark;
  final Color textMuted;
  final Color primarySoft;

  const _AnimatedMenuItem({
    required this.selected,
    required this.title,
    required this.onTap,
    required this.svgBuilder,
    required this.textDark,
    required this.textMuted,
    required this.primarySoft,
  });

  @override
  State<_AnimatedMenuItem> createState() => _AnimatedMenuItemState();
}

class _AnimatedMenuItemState extends State<_AnimatedMenuItem>
    with SingleTickerProviderStateMixin {
  bool _pressed = false;
  late AnimationController _pulseController;

  @override
  void initState() {
    super.initState();
    _pulseController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 1200),
    );
  }

  @override
  void didUpdateWidget(covariant _AnimatedMenuItem oldWidget) {
    super.didUpdateWidget(oldWidget);
    if (widget.selected && !oldWidget.selected) {
      _pulseController.forward(from: 0);
    }
  }

  @override
  void dispose() {
    _pulseController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTapDown: (_) => setState(() => _pressed = true),
      onTapUp: (_) => setState(() => _pressed = false),
      onTapCancel: () => setState(() => _pressed = false),
      onTap: widget.onTap,
      behavior: HitTestBehavior.opaque,
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 250),
        curve: Curves.easeOutCubic,
        margin: const EdgeInsets.symmetric(horizontal: 3),
        decoration: BoxDecoration(
          color: widget.selected
              ? widget.primarySoft
              : Colors.transparent,
          borderRadius: BorderRadius.circular(12),
        ),
        child: Stack(
          alignment: Alignment.center,
          children: [
            if (widget.selected)
              Positioned.fill(
                child: AnimatedBuilder(
                  animation: _pulseController,
                  builder: (context, _) {
                    final t = _pulseController.value;
                    return Container(
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(12),
                        color: _HomeScreenState.primary
                            .withOpacity((1 - t) * 0.15),
                      ),
                    );
                  },
                ),
              ),
            Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                AnimatedScale(
                  scale: widget.selected ? 1.15 : (_pressed ? 0.9 : 1.0),
                  duration: const Duration(milliseconds: 250),
                  curve: Curves.easeOutBack,
                  child: AnimatedSlide(
                    offset: widget.selected
                        ? const Offset(0, -0.08)
                        : Offset.zero,
                    duration: const Duration(milliseconds: 250),
                    curve: Curves.easeOut,
                    child: widget.svgBuilder(
                      widget.selected
                          ? _HomeScreenState.primaryDark
                          : widget.textMuted,
                      21,
                    ),
                  ),
                ),
                const SizedBox(height: 3),
                AnimatedDefaultTextStyle(
                  duration: const Duration(milliseconds: 200),
                  style: TextStyle(
                    fontSize: 10,
                    fontWeight:
                        widget.selected ? FontWeight.bold : FontWeight.w500,
                    color: widget.selected
                        ? _HomeScreenState.primaryDark
                        : widget.textMuted,
                  ),
                  child: Text(
                    widget.title,
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                    textAlign: TextAlign.center,
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}

// ═════════════════════════════════════════════════
// 🔔 BOUTON CLOCHE ANIMÉ
// ═════════════════════════════════════════════════

class _AnimatedBellButton extends StatefulWidget {
  final VoidCallback onTap;
  final Widget Function(Color color, double size) svgBuilder;
  final Color iconColor;

  const _AnimatedBellButton({
    required this.onTap,
    required this.svgBuilder,
    required this.iconColor,
  });

  @override
  State<_AnimatedBellButton> createState() => _AnimatedBellButtonState();
}

class _AnimatedBellButtonState extends State<_AnimatedBellButton>
    with TickerProviderStateMixin {
  late AnimationController _shakeController;
  late AnimationController _waveController;

  @override
  void initState() {
    super.initState();
    _shakeController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 600),
    );
    _waveController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 800),
    );
  }

  @override
  void dispose() {
    _shakeController.dispose();
    _waveController.dispose();
    super.dispose();
  }

  void _handleTap() {
    _shakeController.forward(from: 0);
    _waveController.forward(from: 0);
    widget.onTap();
  }

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: _handleTap,
      behavior: HitTestBehavior.opaque,
      child: Stack(
        alignment: Alignment.center,
        children: [
          AnimatedBuilder(
            animation: _waveController,
            builder: (context, _) {
              final t = _waveController.value;
              if (t == 0) return const SizedBox.shrink();

              final size = 40 + t * 40;
              return Opacity(
                opacity: (1 - t).clamp(0.0, 1.0),
                child: Container(
                  width: size,
                  height: size,
                  decoration: BoxDecoration(
                    shape: BoxShape.circle,
                    border: Border.all(
                      color: _HomeScreenState.primary.withOpacity(0.5),
                      width: 2,
                    ),
                  ),
                ),
              );
            },
          ),

          AnimatedBuilder(
            animation: _shakeController,
            builder: (context, child) {
              final t = _shakeController.value;
              final angle = math.sin(t * math.pi * 6) * (1 - t) * 0.4;
              return Transform.rotate(angle: angle, child: child);
            },
            child: Padding(
              padding: const EdgeInsets.all(8),
              child: widget.svgBuilder(widget.iconColor, 24),
            ),
          ),

          Positioned(
            right: 6,
            top: 5,
            child: TweenAnimationBuilder<double>(
              tween: Tween(begin: 0.9, end: 1.1),
              duration: const Duration(milliseconds: 800),
              curve: Curves.easeInOut,
              builder: (context, value, child) =>
                  Transform.scale(scale: value, child: child),
              child: Container(
                width: 9,
                height: 9,
                decoration: BoxDecoration(
                  color: const Color(0xFFEF4444),
                  shape: BoxShape.circle,
                  border: Border.all(color: Colors.white, width: 1.5),
                  boxShadow: [
                    BoxShadow(
                      color: const Color(0xFFEF4444).withOpacity(0.6),
                      blurRadius: 6,
                      spreadRadius: 1,
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
}

class _MenuItem {
  final String title;
  final String iconAsset;

  const _MenuItem({
    required this.title,
    required this.iconAsset,
  });
}
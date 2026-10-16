import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:flutter_file_dialog/flutter_file_dialog.dart';
import 'package:ecole_eden/core/theme/app_theme.dart';

import '../../services/api_service.dart';
import 'bulletin_pdf_screen.dart';

class BulletinsScreen extends StatefulWidget {
  const BulletinsScreen({super.key});

  @override
  State<BulletinsScreen> createState() => _BulletinsScreenState();
}

class _BulletinsScreenState extends State<BulletinsScreen> {
  bool _isLoading = true;
  bool _isSaving = false;
  String? _error;
  List<Map<String, dynamic>> _bulletins = [];

  // ═════════════════════════════════════════════
  // 🎨 COULEURS DE MARQUE — BLEU
  // ═════════════════════════════════════════════
  static const Color primary = Color(0xFF2563EB);
  static const Color primaryDark = Color(0xFF1D4ED8);

  @override
  void initState() {
    super.initState();
    _loadBulletins();
  }

  // --------------------------------------------------
  // Charger les bulletins depuis l'API Laravel.
  // --------------------------------------------------

  Future<void> _loadBulletins() async {
    if (!mounted) return;

    setState(() {
      _isLoading = true;
      _error = null;
    });

    try {
      final response = await ApiService.get('/bulletins');
      final items = response['bulletins'] as List? ?? [];

      if (!mounted) return;

      setState(() {
        _bulletins = items
            .map((item) => Map<String, dynamic>.from(item))
            .toList();
        _isLoading = false;
      });
    } catch (e) {
      if (!mounted) return;

      setState(() {
        _error = e.toString().replaceFirst('Exception: ', '');
        _isLoading = false;
      });
    }
  }

  // --------------------------------------------------
  // Consulter le bulletin dans l'application.
  // --------------------------------------------------

  Future<void> _viewBulletin(
    Map<String, dynamic> bulletin,
  ) async {
    try {
      final id = int.parse(bulletin['id'].toString());

      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Chargement du bulletin...'),
          duration: Duration(seconds: 2),
        ),
      );

      final bytes = await ApiService.fetchBulletinPdf(id);

      if (!mounted) return;

      final student =
          (bulletin['student_name'] ?? 'Élève').toString();

      final title = 'Bulletin - $student';

      await Navigator.of(context).push(
        MaterialPageRoute(
          builder: (_) => BulletinPdfScreen(
            pdfBytes: bytes,
            title: title,
          ),
        ),
      );
    } catch (e) {
      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Erreur lors de l’ouverture : $e'),
          duration: const Duration(seconds: 5),
        ),
      );
    }
  }

  // --------------------------------------------------
  // Enregistrer le PDF dans un emplacement choisi.
  // --------------------------------------------------

  Future<void> _saveBulletin(
    Map<String, dynamic> bulletin,
  ) async {
    if (_isSaving) return;

    setState(() {
      _isSaving = true;
    });

    try {
      final id = int.parse(bulletin['id'].toString());

      final bytes = await ApiService.fetchBulletinPdf(id);

      if (!mounted) return;

      final student = (bulletin['student_name'] ?? 'eleve')
          .toString()
          .replaceAll(RegExp(r'[\\/:*?"<>|]'), '_');

      final fileName = 'Bulletin_$student.pdf';

      final savedPath = await FlutterFileDialog.saveFile(
        params: SaveFileDialogParams(
          data: bytes,
          fileName: fileName,
          mimeTypesFilter: ['application/pdf'],
        ),
      );

      if (!mounted) return;

      if (savedPath == null) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(
            content: Text('Enregistrement annulé.'),
          ),
        );
        return;
      }

      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Bulletin enregistré avec succès.'),
          duration: Duration(seconds: 4),
        ),
      );
    } catch (e) {
      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Erreur de téléchargement : $e'),
          duration: const Duration(seconds: 5),
        ),
      );
    } finally {
      if (mounted) {
        setState(() {
          _isSaving = false;
        });
      }
    }
  }

  // --------------------------------------------------
  // Afficher une icône SVG teintée.
  // --------------------------------------------------

  Widget _svg({
    required String asset,
    required Color color,
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

  // --------------------------------------------------
  // En-tête principal.
  // --------------------------------------------------

  @override
  Widget build(BuildContext context) {
    final textDark = AppTheme.textDark(context);
    final textMuted = AppTheme.textMuted(context);
    final background = Theme.of(context).scaffoldBackgroundColor;
    final cardColor = AppTheme.cardColor(context);
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
            // 🌟 Logo avec glow bleu
            _GlowingFileLogo(
              svgBuilder: (color, size) => _svg(
                asset: 'assets/icons/file-text.svg',
                color: color,
                size: size,
              ),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisSize: MainAxisSize.min,
                children: [
                  Text(
                    'Mes bulletins',
                    style: TextStyle(
                      color: textDark,
                      fontSize: 17,
                      fontWeight: FontWeight.bold,
                      letterSpacing: -0.3,
                    ),
                  ),
                  const SizedBox(height: 2),
                  Text(
                    'Consultez vos résultats scolaires',
                    style: TextStyle(
                      color: textMuted,
                      fontSize: 11,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
        actions: [
          Padding(
            padding: const EdgeInsets.only(right: 8),
            child: _RefreshButton(
              isLoading: _isLoading,
              onTap: _loadBulletins,
              svgBuilder: (color, size) => _svg(
                asset: 'assets/icons/refresh.svg',
                color: color,
                size: size,
              ),
            ),
          ),
        ],
      ),
      body: _buildBody(),
    );
  }

  // --------------------------------------------------
  // Contenu principal.
  // --------------------------------------------------

  Widget _buildBody() {
    final textDark = AppTheme.textDark(context);
    final textMuted = AppTheme.textMuted(context);
    final cardColor = AppTheme.cardColor(context);
    final primarySoft = AppTheme.primarySoftColor(context);

    // ── Chargement ──
    if (_isLoading) {
      return Center(
        child: Column(
          mainAxisSize: MainAxisSize.min,
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
                      color: primary.withOpacity(0.2),
                      blurRadius: 12,
                      offset: const Offset(0, 4),
                    ),
                  ],
                ),
                padding: const EdgeInsets.all(18),
                child: _svg(
                  asset: 'assets/icons/file-text.svg',
                  color: primaryDark,
                  size: 32,
                ),
              ),
            ),
            const SizedBox(height: 20),
            const SizedBox(
              width: 28,
              height: 28,
              child: CircularProgressIndicator(
                strokeWidth: 2.5,
                color: primary,
              ),
            ),
            const SizedBox(height: 16),
            Text(
              'Chargement des bulletins...',
              style: TextStyle(
                color: textMuted,
                fontSize: 13.5,
                fontWeight: FontWeight.w500,
              ),
            ),
          ],
        ),
      );
    }

    // ── Erreur ──
    if (_error != null) {
      return Center(
        child: Padding(
          padding: const EdgeInsets.all(24),
          child: Column(
            mainAxisSize: MainAxisSize.min,
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
              Text(
                'Impossible de charger les bulletins',
                textAlign: TextAlign.center,
                style: TextStyle(
                  color: textDark,
                  fontSize: 17,
                  fontWeight: FontWeight.bold,
                  letterSpacing: -0.3,
                ),
              ),
              const SizedBox(height: 10),
              Text(
                _error!,
                textAlign: TextAlign.center,
                style: TextStyle(
                  color: textMuted,
                  fontSize: 13.5,
                  height: 1.5,
                  fontWeight: FontWeight.w500,
                ),
              ),
              const SizedBox(height: 22),
              _RetryButton(
                onTap: _loadBulletins,
                svgBuilder: (color, size) => _svg(
                  asset: 'assets/icons/refresh.svg',
                  color: color,
                  size: size,
                ),
              ),
            ],
          ),
        ),
      );
    }

    // ── Aucun bulletin ──
    if (_bulletins.isEmpty) {
      return RefreshIndicator(
        onRefresh: _loadBulletins,
        color: primary,
        child: ListView(
          physics: const AlwaysScrollableScrollPhysics(),
          padding: const EdgeInsets.all(24),
          children: [
            const SizedBox(height: 80),
            Center(
              child: Container(
                width: 110,
                height: 110,
                decoration: BoxDecoration(
                  color: primarySoft,
                  shape: BoxShape.circle,
                ),
                alignment: Alignment.center,
                child: Container(
                  width: 78,
                  height: 78,
                  decoration: BoxDecoration(
                    color: cardColor,
                    shape: BoxShape.circle,
                    boxShadow: [
                      BoxShadow(
                        color: primary.withOpacity(0.2),
                        blurRadius: 14,
                        offset: const Offset(0, 5),
                      ),
                    ],
                  ),
                  padding: const EdgeInsets.all(20),
                  child: _svg(
                    asset: 'assets/icons/file-text.svg',
                    color: primaryDark,
                    size: 38,
                  ),
                ),
              ),
            ),
            const SizedBox(height: 26),
            Text(
              'Aucun bulletin disponible',
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
              'Les bulletins apparaîtront ici après leur publication '
              'par l’administration.',
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
      );
    }

    // ── Liste des bulletins ──
    return RefreshIndicator(
      onRefresh: _loadBulletins,
      color: primary,
      child: ListView.separated(
        physics: const AlwaysScrollableScrollPhysics(),
        padding: const EdgeInsets.all(16),
        itemCount: _bulletins.length,
        separatorBuilder: (_, __) => const SizedBox(height: 12),
        itemBuilder: (context, index) {
          return _FadeSlideIn(
            delay: index * 70,
            child: _buildBulletinCard(_bulletins[index]),
          );
        },
      ),
    );
  }

  // --------------------------------------------------
  // Carte de chaque bulletin.
  // --------------------------------------------------

  Widget _buildBulletinCard(
    Map<String, dynamic> bulletin,
  ) {
    final textDark = AppTheme.textDark(context);
    final textMuted = AppTheme.textMuted(context);
    final cardColor = AppTheme.cardColor(context);
    final border = AppTheme.border(context);
    final primarySoft = AppTheme.primarySoftColor(context);

    final studentName =
        bulletin['student_name']?.toString() ?? 'Élève';
    final term = bulletin['term']?.toString() ?? '';
    final schoolYear = bulletin['school_year']?.toString() ?? '';

    return _PressableBulletinCard(
      cardColor: cardColor,
      borderColor: border,
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            // ── En-tête : avatar + infos ──
            Row(
              children: [
                Container(
                  width: 54,
                  height: 54,
                  decoration: BoxDecoration(
                    gradient: const LinearGradient(
                      colors: [primary, primaryDark],
                      begin: Alignment.topLeft,
                      end: Alignment.bottomRight,
                    ),
                    borderRadius: BorderRadius.circular(14),
                    boxShadow: [
                      BoxShadow(
                        color: primary.withOpacity(0.35),
                        blurRadius: 10,
                        offset: const Offset(0, 4),
                      ),
                    ],
                  ),
                  padding: const EdgeInsets.all(14),
                  child: SvgPicture.asset(
                    'assets/icons/file-text.svg',
                    colorFilter: const ColorFilter.mode(
                      Colors.white,
                      BlendMode.srcIn,
                    ),
                  ),
                ),
                const SizedBox(width: 14),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        studentName,
                        maxLines: 1,
                        overflow: TextOverflow.ellipsis,
                        style: TextStyle(
                          color: textDark,
                          fontSize: 15.5,
                          fontWeight: FontWeight.bold,
                          letterSpacing: -0.2,
                        ),
                      ),
                      const SizedBox(height: 7),
                      Wrap(
                        crossAxisAlignment: WrapCrossAlignment.center,
                        spacing: 8,
                        runSpacing: 5,
                        children: [
                          if (term.isNotEmpty)
                            Container(
                              padding: const EdgeInsets.symmetric(
                                horizontal: 8,
                                vertical: 3,
                              ),
                              decoration: BoxDecoration(
                                color: primarySoft,
                                borderRadius: BorderRadius.circular(6),
                                border: Border.all(
                                  color: primary.withOpacity(0.3),
                                ),
                              ),
                              child: Text(
                                term,
                                style: const TextStyle(
                                  color: primaryDark,
                                  fontSize: 11,
                                  fontWeight: FontWeight.w600,
                                ),
                              ),
                            ),
                          if (schoolYear.isNotEmpty)
                            Text(
                              schoolYear,
                              style: TextStyle(
                                color: textMuted,
                                fontSize: 12,
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

            const SizedBox(height: 14),

            // ── Actions ──
            Row(
              children: [
                // Bouton "Consulter" (outlined)
                Expanded(
                  child: _ActionButton(
                    onTap: () => _viewBulletin(bulletin),
                    iconAsset: 'assets/icons/eye.svg',
                    label: 'Consulter',
                    filled: false,
                    svgBuilder: _svg,
                    cardColor: cardColor,
                    borderColor: border,
                  ),
                ),

                const SizedBox(width: 8),

                // Bouton "Télécharger" (soft bleu)
                Expanded(
                  child: _ActionButton(
                    onTap: _isSaving ? null : () => _saveBulletin(bulletin),
                    iconAsset: 'assets/icons/download.svg',
                    label: _isSaving ? 'En cours...' : 'Télécharger',
                    filled: true,
                    isLoading: _isSaving,
                    svgBuilder: _svg,
                    cardColor: cardColor,
                    borderColor: border,
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
// 🌟 LOGO AVEC GLOW BLEU
// ═════════════════════════════════════════════════

class _GlowingFileLogo extends StatefulWidget {
  final Widget Function(Color color, double size) svgBuilder;

  const _GlowingFileLogo({required this.svgBuilder});

  @override
  State<_GlowingFileLogo> createState() => _GlowingFileLogoState();
}

class _GlowingFileLogoState extends State<_GlowingFileLogo>
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
                  _BulletinsScreenState.primary,
                  _BulletinsScreenState.primaryDark,
                ],
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
              ),
              borderRadius: BorderRadius.circular(12),
              boxShadow: [
                BoxShadow(
                  color: _BulletinsScreenState.primary.withOpacity(glow),
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
// 🔄 BOUTON REFRESH (avec spinner bleu)
// ═════════════════════════════════════════════════

class _RefreshButton extends StatelessWidget {
  final bool isLoading;
  final VoidCallback onTap;
  final Widget Function(Color color, double size) svgBuilder;

  const _RefreshButton({
    required this.isLoading,
    required this.onTap,
    required this.svgBuilder,
  });

  @override
  Widget build(BuildContext context) {
    final textDark = AppTheme.textDark(context);

    return IconButton(
      onPressed: isLoading ? null : onTap,
      tooltip: 'Actualiser',
      icon: isLoading
          ? const SizedBox(
              width: 22,
              height: 22,
              child: CircularProgressIndicator(
                strokeWidth: 2.2,
                color: _BulletinsScreenState.primary,
              ),
            )
          : svgBuilder(textDark, 22),
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
            horizontal: 22,
            vertical: 12,
          ),
          decoration: BoxDecoration(
            color: _BulletinsScreenState.primary,
            borderRadius: BorderRadius.circular(10),
            boxShadow: [
              BoxShadow(
                color: _BulletinsScreenState.primary.withOpacity(0.35),
                blurRadius: 12,
                offset: const Offset(0, 5),
              ),
            ],
          ),
          child: Row(
            mainAxisSize: MainAxisSize.min,
            children: [
              widget.svgBuilder(Colors.white, 16),
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
    );
  }
}

// ═════════════════════════════════════════════════
// 🎯 BOUTON D'ACTION (Consulter / Télécharger)
// ═════════════════════════════════════════════════

class _ActionButton extends StatefulWidget {
  final VoidCallback? onTap;
  final String iconAsset;
  final String label;
  final bool filled;
  final bool isLoading;
  final Widget Function({
    required String asset,
    required Color color,
    double size,
  }) svgBuilder;
  final Color cardColor;
  final Color borderColor;

  const _ActionButton({
    required this.onTap,
    required this.iconAsset,
    required this.label,
    required this.filled,
    required this.svgBuilder,
    required this.cardColor,
    required this.borderColor,
    this.isLoading = false,
  });

  @override
  State<_ActionButton> createState() => _ActionButtonState();
}

class _ActionButtonState extends State<_ActionButton> {
  bool _pressed = false;

  @override
  Widget build(BuildContext context) {
    final enabled = widget.onTap != null;
    final primarySoft = AppTheme.primarySoftColor(context);
    final textMuted = AppTheme.textMuted(context);

    final bgColor = widget.filled
        ? primarySoft
        : widget.cardColor;

    final fgColor = widget.filled
        ? _BulletinsScreenState.primaryDark
        : textMuted;

    final borderColor = widget.filled
        ? _BulletinsScreenState.primary.withOpacity(0.3)
        : widget.borderColor;

    return GestureDetector(
      onTapDown:
          enabled ? (_) => setState(() => _pressed = true) : null,
      onTapUp:
          enabled ? (_) => setState(() => _pressed = false) : null,
      onTapCancel:
          enabled ? () => setState(() => _pressed = false) : null,
      onTap: widget.onTap,
      child: AnimatedScale(
        scale: _pressed ? 0.97 : 1.0,
        duration: const Duration(milliseconds: 120),
        child: AnimatedContainer(
          duration: const Duration(milliseconds: 180),
          padding: const EdgeInsets.symmetric(
            vertical: 13,
            horizontal: 6,
          ),
          decoration: BoxDecoration(
            color: enabled ? bgColor : bgColor.withOpacity(0.6),
            borderRadius: BorderRadius.circular(
              widget.filled ? 16 : 28,
            ),
            border: Border.all(
              color: borderColor,
              width: 1,
            ),
            boxShadow: widget.filled
                ? [
                    BoxShadow(
                      color: _BulletinsScreenState.primary
                          .withOpacity(0.15),
                      blurRadius: 10,
                      offset: const Offset(0, 4),
                    ),
                  ]
                : null,
          ),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              if (widget.isLoading)
                SizedBox(
                  width: 18,
                  height: 18,
                  child: CircularProgressIndicator(
                    strokeWidth: 2,
                    color: fgColor,
                  ),
                )
              else
                widget.svgBuilder(
                  asset: widget.iconAsset,
                  color: enabled ? fgColor : fgColor.withOpacity(0.5),
                  size: 20,
                ),
              const SizedBox(width: 8),
              Flexible(
                child: Text(
                  widget.label,
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                  style: TextStyle(
                    color:
                        enabled ? fgColor : fgColor.withOpacity(0.5),
                    fontSize: 14,
                    fontWeight: FontWeight.w600,
                    letterSpacing: -0.2,
                  ),
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
// 🎨 CARTE BULLETIN PRESSABLE (hover bleu)
// ═════════════════════════════════════════════════

class _PressableBulletinCard extends StatefulWidget {
  final Widget child;
  final Color cardColor;
  final Color borderColor;

  const _PressableBulletinCard({
    required this.child,
    required this.cardColor,
    required this.borderColor,
  });

  @override
  State<_PressableBulletinCard> createState() =>
      _PressableBulletinCardState();
}

class _PressableBulletinCardState extends State<_PressableBulletinCard> {
  bool _isHovered = false;

  @override
  Widget build(BuildContext context) {
    return MouseRegion(
      onEnter: (_) => setState(() => _isHovered = true),
      onExit: (_) => setState(() => _isHovered = false),
      cursor: SystemMouseCursors.click,
      child: AnimatedScale(
        scale: _isHovered ? 1.015 : 1.0,
        duration: const Duration(milliseconds: 200),
        curve: Curves.easeOutCubic,
        child: AnimatedContainer(
          duration: const Duration(milliseconds: 200),
          curve: Curves.easeOutCubic,
          decoration: BoxDecoration(
            color: widget.cardColor,
            borderRadius: BorderRadius.circular(16),
            border: Border.all(
              color: _isHovered
                  ? _BulletinsScreenState.primary.withOpacity(0.5)
                  : widget.borderColor,
              width: _isHovered ? 1.5 : 1.0,
            ),
            boxShadow: [
              BoxShadow(
                color: _BulletinsScreenState.primary
                    .withOpacity(_isHovered ? 0.15 : 0.06),
                blurRadius: _isHovered ? 22 : 12,
                offset: Offset(0, _isHovered ? 10 : 4),
              ),
            ],
          ),
          child: widget.child,
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
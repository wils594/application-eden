import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';

import '../../core/routes/app_routes.dart';
import '../../core/theme/app_theme.dart'; // ✅ import corrigé
import '../../services/auth_service.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen>
    with TickerProviderStateMixin {
  final _formKey = GlobalKey<FormState>();

  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();

  bool _obscurePassword = true;
  bool _isLoading = false;

  // ═════════════════════════════════════════════
  // 🎨 COULEURS DE MARQUE (identiques Light/Dark)
  // ═════════════════════════════════════════════
  static const Color _primary = AppTheme.primary;
  static const Color _primaryDark = AppTheme.primaryDark;

  @override
  void dispose() {
    _emailController.dispose();
    _passwordController.dispose();
    super.dispose();
  }

  Future<void> _login() async {
    if (!_formKey.currentState!.validate()) {
      return;
    }

    setState(() {
      _isLoading = true;
    });

    try {
      final response = await AuthService.login(
        login: _emailController.text.trim(),
        password: _passwordController.text,
      );

      if (!mounted) return;

      debugPrint('Connexion réussie : ${response['user']}');

      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Connexion réussie.'),
          backgroundColor: Colors.green,
        ),
      );

      Navigator.pushReplacementNamed(
        context,
        AppRoutes.home,
      );
    } catch (e) {
      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(
            e.toString().replaceFirst('Exception: ', ''),
          ),
          backgroundColor: Colors.red,
        ),
      );
    } finally {
      if (mounted) {
        setState(() {
          _isLoading = false;
        });
      }
    }
  }

  /// Helper SVG teinté
  Widget _svg({
    required String asset,
    required Color color,
    double size = 20,
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
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(
            horizontal: 24,
            vertical: 24,
          ),
          child: Form(
            key: _formKey,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                const SizedBox(height: 20),

                // ═══════════════════════════════════════
                // 🎨 LOGO SVG ÉCOLE + TITRE HERO
                // ═══════════════════════════════════════
                Center(
                  child: _FadeSlideIn(
                    delay: 0,
                    child: _buildLogo(),
                  ),
                ),

                const SizedBox(height: 24),

                _FadeSlideIn(
                  delay: 80,
                  child: Text(
                    'Bienvenue sur',
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      fontSize: 15,
                      color: AppTheme.textMuted(context),
                      fontWeight: FontWeight.w500,
                      letterSpacing: 0.3,
                    ),
                  ),
                ),

                const SizedBox(height: 4),

                _FadeSlideIn(
                  delay: 140,
                  child: ShaderMask(
                    shaderCallback: (bounds) => const LinearGradient(
                      colors: [AppTheme.primaryDark, AppTheme.primary],
                      begin: Alignment.centerLeft,
                      end: Alignment.centerRight,
                    ).createShader(bounds),
                    child: const Text(
                      'École Eden',
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        fontSize: 34,
                        fontWeight: FontWeight.bold,
                        color: Colors.white,
                        letterSpacing: -1,
                      ),
                    ),
                  ),
                ),

                const SizedBox(height: 8),

                _FadeSlideIn(
                  delay: 200,
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Container(
                        width: 6,
                        height: 6,
                        decoration: const BoxDecoration(
                          color: AppTheme.primary,
                          shape: BoxShape.circle,
                        ),
                      ),
                      const SizedBox(width: 8),
                      Text(
                        'Espace Parent',
                        style: TextStyle(
                          fontSize: 14,
                          color: AppTheme.textMuted(context),
                          fontWeight: FontWeight.w600,
                          letterSpacing: 0.5,
                        ),
                      ),
                    ],
                  ),
                ),

                const SizedBox(height: 44),

                // ═══════════════════════════════════════
                // 📋 FORMULAIRE (dans une carte)
                // ═══════════════════════════════════════
                _FadeSlideIn(
                  delay: 260,
                  child: Container(
                    padding: const EdgeInsets.all(24),
                    decoration: BoxDecoration(
                      color: AppTheme.cardColor(context),
                      borderRadius: BorderRadius.circular(20),
                      border: Border.all(color: AppTheme.border(context)),
                      boxShadow: [
                        BoxShadow(
                          color: Colors.black.withOpacity(0.04),
                          blurRadius: 24,
                          offset: const Offset(0, 8),
                        ),
                        BoxShadow(
                          color: AppTheme.primary.withOpacity(0.06),
                          blurRadius: 40,
                          offset: const Offset(0, 16),
                        ),
                      ],
                    ),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.stretch,
                      children: [
                        // ── Titre ──
                        Row(
                          children: [
                            Container(
                              width: 4,
                              height: 22,
                              decoration: BoxDecoration(
                                color: AppTheme.primary,
                                borderRadius: BorderRadius.circular(4),
                              ),
                            ),
                            const SizedBox(width: 10),
                            Text(
                              'Connexion',
                              style: TextStyle(
                                fontSize: 20,
                                fontWeight: FontWeight.bold,
                                color: AppTheme.textDark(context),
                                letterSpacing: -0.4,
                              ),
                            ),
                          ],
                        ),

                        const SizedBox(height: 6),

                        Text(
                          'Connectez-vous pour accéder à votre espace.',
                          style: TextStyle(
                            fontSize: 13.5,
                            color: AppTheme.textMuted(context),
                            height: 1.4,
                            fontWeight: FontWeight.w500,
                          ),
                        ),

                        const SizedBox(height: 22),

                        // ── Champ Email ──
                        TextFormField(
                          controller: _emailController,
                          keyboardType: TextInputType.emailAddress,
                          enabled: !_isLoading,
                          style: TextStyle(
                            color: AppTheme.textDark(context),
                            fontWeight: FontWeight.w500,
                            fontSize: 14.5,
                          ),
                          decoration: InputDecoration(
                            labelText: 'Email ou téléphone',
                            labelStyle: TextStyle(
                              color: AppTheme.textMuted(context),
                              fontWeight: FontWeight.w500,
                            ),
                            floatingLabelStyle: const TextStyle(
                              color: AppTheme.primary,
                              fontWeight: FontWeight.w600,
                            ),
                            filled: true,
                            fillColor:
                                AppTheme.primarySoftColor(context),
                            prefixIcon: Padding(
                              padding: const EdgeInsets.all(14),
                              child: _svg(
                                asset: 'assets/icons/email.svg',
                                color: AppTheme.textMuted(context),
                                size: 20,
                              ),
                            ),
                            contentPadding: const EdgeInsets.symmetric(
                              horizontal: 16,
                              vertical: 18,
                            ),
                            enabledBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(12),
                              borderSide: BorderSide(
                                color: AppTheme.border(context),
                              ),
                            ),
                            focusedBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(12),
                              borderSide: const BorderSide(
                                color: AppTheme.primary,
                                width: 1.6,
                              ),
                            ),
                            errorBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(12),
                              borderSide: const BorderSide(
                                color: Colors.redAccent,
                              ),
                            ),
                            focusedErrorBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(12),
                              borderSide: const BorderSide(
                                color: Colors.redAccent,
                                width: 1.6,
                              ),
                            ),
                          ),
                          validator: (value) {
                            if (value == null || value.trim().isEmpty) {
                              return 'Veuillez saisir votre email ou téléphone';
                            }
                            return null;
                          },
                        ),

                        const SizedBox(height: 16),

                        // ── Champ Mot de passe ──
                        TextFormField(
                          controller: _passwordController,
                          obscureText: _obscurePassword,
                          enabled: !_isLoading,
                          style: TextStyle(
                            color: AppTheme.textDark(context),
                            fontWeight: FontWeight.w500,
                            fontSize: 14.5,
                          ),
                          decoration: InputDecoration(
                            labelText: 'Mot de passe',
                            labelStyle: TextStyle(
                              color: AppTheme.textMuted(context),
                              fontWeight: FontWeight.w500,
                            ),
                            floatingLabelStyle: const TextStyle(
                              color: AppTheme.primary,
                              fontWeight: FontWeight.w600,
                            ),
                            filled: true,
                            fillColor:
                                AppTheme.primarySoftColor(context),
                            prefixIcon: Padding(
                              padding: const EdgeInsets.all(14),
                              child: _svg(
                                asset: 'assets/icons/lock.svg',
                                color: AppTheme.textMuted(context),
                                size: 20,
                              ),
                            ),
                            suffixIcon: IconButton(
                              onPressed: _isLoading
                                  ? null
                                  : () {
                                      setState(() {
                                        _obscurePassword =
                                            !_obscurePassword;
                                      });
                                    },
                              icon: _svg(
                                asset: _obscurePassword
                                    ? 'assets/icons/eye.svg'
                                    : 'assets/icons/eye_off.svg',
                                color: AppTheme.textMuted(context),
                                size: 20,
                              ),
                            ),
                            contentPadding: const EdgeInsets.symmetric(
                              horizontal: 16,
                              vertical: 18,
                            ),
                            enabledBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(12),
                              borderSide: BorderSide(
                                color: AppTheme.border(context),
                              ),
                            ),
                            focusedBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(12),
                              borderSide: const BorderSide(
                                color: AppTheme.primary,
                                width: 1.6,
                              ),
                            ),
                            errorBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(12),
                              borderSide: const BorderSide(
                                color: Colors.redAccent,
                              ),
                            ),
                            focusedErrorBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(12),
                              borderSide: const BorderSide(
                                color: Colors.redAccent,
                                width: 1.6,
                              ),
                            ),
                          ),
                          validator: (value) {
                            if (value == null || value.isEmpty) {
                              return 'Veuillez saisir votre mot de passe';
                            }
                            return null;
                          },
                        ),

                        const SizedBox(height: 8),

                        // ── Mot de passe oublié ──
                        Align(
                          alignment: Alignment.centerRight,
                          child: TextButton(
                            onPressed: _isLoading
                                ? null
                                : () {
                                    // À développer plus tard.
                                  },
                            style: TextButton.styleFrom(
                              foregroundColor: AppTheme.primary,
                              padding: const EdgeInsets.symmetric(
                                horizontal: 8,
                                vertical: 4,
                              ),
                            ),
                            child: const Text(
                              'Mot de passe oublié ?',
                              style: TextStyle(
                                fontWeight: FontWeight.w600,
                                fontSize: 13.5,
                              ),
                            ),
                          ),
                        ),

                        const SizedBox(height: 14),

                        // ═══════════════════════════════════════
                        // 🚀 BOUTON PRINCIPAL
                        // ═══════════════════════════════════════
                        _PressablePrimaryButton(
                          onTap: _isLoading ? null : _login,
                          isLoading: _isLoading,
                          child: const Row(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Text(
                                'Se connecter',
                                style: TextStyle(
                                  fontSize: 15.5,
                                  fontWeight: FontWeight.bold,
                                  color: Colors.white,
                                  letterSpacing: 0.3,
                                ),
                              ),
                              SizedBox(width: 8),
                              Icon(
                                Icons.arrow_forward_rounded,
                                color: Colors.white,
                                size: 20,
                              ),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ),
                ),

                const SizedBox(height: 16),

                // ── Mention sécurité ──
                _FadeSlideIn(
                  delay: 340,
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Container(
                        padding: const EdgeInsets.all(4),
                        decoration: BoxDecoration(
                          color: AppTheme.primarySoftColor(context),
                          shape: BoxShape.circle,
                        ),
                        child: _svg(
                          asset: 'assets/icons/lock.svg',
                          color: AppTheme.primaryDark,
                          size: 12,
                        ),
                      ),
                      const SizedBox(width: 8),
                      Text(
                        'Connexion sécurisée SSL',
                        style: TextStyle(
                          fontSize: 12,
                          color: AppTheme.textMuted(context),
                          fontWeight: FontWeight.w500,
                        ),
                      ),
                    ],
                  ),
                ),

                const SizedBox(height: 24),

                // ═══════════════════════════════════════
                // 🆕 LIEN INSCRIPTION
                // ═══════════════════════════════════════
                _FadeSlideIn(
                  delay: 380,
                  child: Container(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 16,
                      vertical: 14,
                    ),
                    decoration: BoxDecoration(
                      color: AppTheme.cardColor(context),
                      borderRadius: BorderRadius.circular(14),
                      border: Border.all(color: AppTheme.border(context)),
                    ),
                    child: Wrap(
                      alignment: WrapAlignment.center,
                      crossAxisAlignment: WrapCrossAlignment.center,
                      children: [
                        Text(
                          'Vous n\u2019avez pas encore de compte ?',
                          style: TextStyle(
                            color: AppTheme.textMuted(context),
                            fontSize: 13,
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                        TextButton(
                          onPressed: _isLoading
                              ? null
                              : () {
                                  Navigator.pushNamed(
                                    context,
                                    AppRoutes.register,
                                  );
                                },
                          style: TextButton.styleFrom(
                            foregroundColor: AppTheme.primaryDark,
                            padding: const EdgeInsets.symmetric(
                              horizontal: 8,
                              vertical: 4,
                            ),
                            minimumSize: Size.zero,
                            tapTargetSize:
                                MaterialTapTargetSize.shrinkWrap,
                          ),
                          child: const Text(
                            'Créer un compte',
                            style: TextStyle(
                              color: AppTheme.primaryDark,
                              fontWeight: FontWeight.bold,
                              fontSize: 13.5,
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                ),

                const SizedBox(height: 30),

                // ── Footer ──
                _FadeSlideIn(
                  delay: 420,
                  child: Text(
                    'École Eden • Espace Parent',
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: AppTheme.textMuted(context),
                      fontSize: 12.5,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                ),

                const SizedBox(height: 12),
              ],
            ),
          ),
        ),
      ),
    );
  }

  // ═════════════════════════════════════════════
  // 🎨 LOGO SVG ÉCOLE avec halo + badge
  // ═════════════════════════════════════════════
  Widget _buildLogo() {
    return Stack(
      alignment: Alignment.center,
      children: [
        // Halo bleu derrière le logo
        Container(
          width: 130,
          height: 130,
          decoration: BoxDecoration(
            shape: BoxShape.circle,
            gradient: RadialGradient(
              colors: [
                AppTheme.primary.withOpacity(0.18),
                AppTheme.primary.withOpacity(0.0),
              ],
            ),
          ),
        ),

        // Cercle contenant le logo SVG école
        Container(
          width: 104,
          height: 104,
          decoration: BoxDecoration(
            gradient: const LinearGradient(
              colors: [AppTheme.primary, AppTheme.primaryDark],
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
            ),
            shape: BoxShape.circle,
            boxShadow: [
              BoxShadow(
                color: AppTheme.primary.withOpacity(0.4),
                blurRadius: 24,
                offset: const Offset(0, 10),
              ),
            ],
          ),
          padding: const EdgeInsets.all(26),

          // ✅ SVG ÉCOLE, en blanc sur fond bleu
          child: SvgPicture.asset(
            'assets/icons/school.svg',
            fit: BoxFit.contain,
            colorFilter: const ColorFilter.mode(
              Colors.white,
              BlendMode.srcIn,
            ),
          ),
        ),

        // Badge "vérifié" en bas à droite
        Positioned(
          right: 4,
          bottom: 4,
          child: Container(
            padding: const EdgeInsets.all(6),
            decoration: BoxDecoration(
              color: AppTheme.cardColor(context),
              shape: BoxShape.circle,
              border: Border.all(color: AppTheme.primary, width: 2),
              boxShadow: [
                BoxShadow(
                  color: AppTheme.primary.withOpacity(0.3),
                  blurRadius: 10,
                  offset: const Offset(0, 4),
                ),
              ],
            ),
            child: const Icon(
              Icons.check_rounded,
              color: AppTheme.primary,
              size: 14,
            ),
          ),
        ),
      ],
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

// ═════════════════════════════════════════════════
// 🚀 BOUTON PRINCIPAL PRESSABLE (bleu)
// ═════════════════════════════════════════════════

class _PressablePrimaryButton extends StatefulWidget {
  final Widget child;
  final VoidCallback? onTap;
  final bool isLoading;

  const _PressablePrimaryButton({
    required this.child,
    required this.onTap,
    this.isLoading = false,
  });

  @override
  State<_PressablePrimaryButton> createState() =>
      _PressablePrimaryButtonState();
}

class _PressablePrimaryButtonState extends State<_PressablePrimaryButton> {
  bool _isPressed = false;

  @override
  Widget build(BuildContext context) {
    final enabled = widget.onTap != null;

    return GestureDetector(
      onTapDown: enabled ? (_) => setState(() => _isPressed = true) : null,
      onTapUp: enabled ? (_) => setState(() => _isPressed = false) : null,
      onTapCancel: enabled ? () => setState(() => _isPressed = false) : null,
      onTap: widget.onTap,
      child: AnimatedScale(
        scale: _isPressed ? 0.97 : 1.0,
        duration: const Duration(milliseconds: 120),
        child: AnimatedContainer(
          duration: const Duration(milliseconds: 180),
          height: 54,
          decoration: BoxDecoration(
            gradient: LinearGradient(
              colors: enabled
                  ? const [
                      AppTheme.primary,
                      AppTheme.primaryDark,
                    ]
                  : [Colors.grey.shade300, Colors.grey.shade400],
              begin: Alignment.centerLeft,
              end: Alignment.centerRight,
            ),
            borderRadius: BorderRadius.circular(14),
            boxShadow: enabled
                ? [
                    BoxShadow(
                      color: AppTheme.primary.withOpacity(0.4),
                      blurRadius: 18,
                      offset: const Offset(0, 8),
                    ),
                  ]
                : null,
          ),
          child: Material(
            color: Colors.transparent,
            borderRadius: BorderRadius.circular(14),
            child: Center(
              child: widget.isLoading
                  ? const SizedBox(
                      width: 24,
                      height: 24,
                      child: CircularProgressIndicator(
                        strokeWidth: 2.5,
                        color: Colors.white,
                      ),
                    )
                  : widget.child,
            ),
          ),
        ),
      ),
    );
  }
}
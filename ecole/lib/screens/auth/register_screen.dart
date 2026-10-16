import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';

import '../../core/routes/app_routes.dart';
import '../../core/theme/app_theme.dart'; // ✅ import corrigé
import '../../services/auth_service.dart';

class RegisterScreen extends StatefulWidget {
  const RegisterScreen({super.key});

  @override
  State<RegisterScreen> createState() => _RegisterScreenState();
}

class _RegisterScreenState extends State<RegisterScreen> {
  final _formKey = GlobalKey<FormState>();

  final _nameController = TextEditingController();
  final _phoneController = TextEditingController();
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();
  final _confirmPasswordController = TextEditingController();

  bool _obscurePassword = true;
  bool _obscureConfirmPassword = true;
  bool _isLoading = false;

  // ═════════════════════════════════════════════
  // 🎨 COULEURS DE MARQUE (identiques Light/Dark)
  // ═════════════════════════════════════════════
  static const Color _primary = AppTheme.primary;
  static const Color _primaryDark = AppTheme.primaryDark;

  @override
  void dispose() {
    _nameController.dispose();
    _phoneController.dispose();
    _emailController.dispose();
    _passwordController.dispose();
    _confirmPasswordController.dispose();
    super.dispose();
  }

  Future<void> _register() async {
    if (!_formKey.currentState!.validate()) {
      return;
    }

    setState(() {
      _isLoading = true;
    });

    try {
      final response = await AuthService.register(
        name: _nameController.text.trim(),
        phone: _phoneController.text.trim(),
        email: _emailController.text.trim(),
        password: _passwordController.text,
        passwordConfirmation: _confirmPasswordController.text,
      );

      if (!mounted) return;

      debugPrint('Inscription réussie : ${response['user']}');

      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Compte créé avec succès.'),
          backgroundColor: Colors.green,
        ),
      );

      Navigator.pushReplacementNamed(
        context,
        AppRoutes.login,
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

  // ═════════════════════════════════════════════
  // Helpers UI
  // ═════════════════════════════════════════════

  Widget _svgPrefix(String asset) {
    return Padding(
      padding: const EdgeInsets.all(14),
      child: SvgPicture.asset(
        asset,
        width: 20,
        height: 20,
        colorFilter: ColorFilter.mode(
          AppTheme.textMuted(context),
          BlendMode.srcIn,
        ),
      ),
    );
  }

  Widget _eyeIcon({
    required bool obscure,
    required VoidCallback onTap,
  }) {
    return IconButton(
      onPressed: _isLoading ? null : onTap,
      icon: SvgPicture.asset(
        obscure
            ? 'assets/icons/eye.svg'
            : 'assets/icons/eye_off.svg',
        width: 20,
        height: 20,
        colorFilter: ColorFilter.mode(
          AppTheme.textMuted(context),
          BlendMode.srcIn,
        ),
      ),
    );
  }

  InputDecoration _fieldDecoration({
    required String label,
    required String iconAsset,
    Widget? suffix,
  }) {
    return InputDecoration(
      labelText: label,
      labelStyle: TextStyle(
        color: AppTheme.textMuted(context),
        fontWeight: FontWeight.w500,
      ),
      floatingLabelStyle: const TextStyle(
        color: AppTheme.primary,
        fontWeight: FontWeight.w600,
      ),
      filled: true,
      fillColor: AppTheme.primarySoftColor(context),
      prefixIcon: _svgPrefix(iconAsset),
      suffixIcon: suffix,
      contentPadding: const EdgeInsets.symmetric(
        horizontal: 16,
        vertical: 18,
      ),
      enabledBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: BorderSide(color: AppTheme.border(context)),
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
        borderSide: const BorderSide(color: Colors.redAccent),
      ),
      focusedErrorBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(
          color: Colors.redAccent,
          width: 1.6,
        ),
      ),
    );
  }

  /// Titre de section avec badge SVG
  Widget _sectionTitle({
    required String title,
    required String iconAsset,
  }) {
    return Row(
      children: [
        Container(
          width: 34,
          height: 34,
          decoration: BoxDecoration(
            color: AppTheme.primarySoftColor(context),
            borderRadius: BorderRadius.circular(10),
            border: Border.all(
              color: AppTheme.primary.withOpacity(0.15),
            ),
          ),
          padding: const EdgeInsets.all(8),
          child: SvgPicture.asset(
            iconAsset,
            colorFilter: const ColorFilter.mode(
              AppTheme.primaryDark,
              BlendMode.srcIn,
            ),
          ),
        ),
        const SizedBox(width: 10),
        Text(
          title,
          style: TextStyle(
            fontSize: 17,
            fontWeight: FontWeight.bold,
            color: AppTheme.textDark(context),
            letterSpacing: -0.3,
          ),
        ),
      ],
    );
  }

  /// Carte englobante avec ombre douce
  Widget _card({required Widget child}) {
    return Container(
      padding: const EdgeInsets.all(18),
      decoration: BoxDecoration(
        color: AppTheme.cardColor(context),
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: AppTheme.border(context)),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.04),
            blurRadius: 20,
            offset: const Offset(0, 8),
          ),
          BoxShadow(
            color: AppTheme.primary.withOpacity(0.05),
            blurRadius: 40,
            offset: const Offset(0, 16),
          ),
        ],
      ),
      child: child,
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(
            horizontal: 20,
            vertical: 16,
          ),
          child: Form(
            key: _formKey,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                // ═══════════════════════════════════════
                // 🔙 Bouton retour
                // ═══════════════════════════════════════
                Align(
                  alignment: Alignment.centerLeft,
                  child: _FadeSlideIn(
                    delay: 0,
                    child: Material(
                      color: Colors.transparent,
                      borderRadius: BorderRadius.circular(12),
                      child: InkWell(
                        borderRadius: BorderRadius.circular(12),
                        onTap: _isLoading
                            ? null
                            : () => Navigator.pop(context),
                        child: Container(
                          width: 44,
                          height: 44,
                          decoration: BoxDecoration(
                            color: AppTheme.cardColor(context),
                            borderRadius: BorderRadius.circular(12),
                            border:
                                Border.all(color: AppTheme.border(context)),
                            boxShadow: [
                              BoxShadow(
                                color: Colors.black.withOpacity(0.03),
                                blurRadius: 8,
                                offset: const Offset(0, 2),
                              ),
                            ],
                          ),
                          alignment: Alignment.center,
                          child: SvgPicture.asset(
                            'assets/icons/arrow_left.svg',
                            width: 20,
                            height: 20,
                            colorFilter: ColorFilter.mode(
                              AppTheme.textDark(context),
                              BlendMode.srcIn,
                            ),
                          ),
                        ),
                      ),
                    ),
                  ),
                ),

                const SizedBox(height: 20),

                // ═══════════════════════════════════════
                // 🎨 Logo (cercle dégradé bleu)
                // ═══════════════════════════════════════
                Center(
                  child: _FadeSlideIn(
                    delay: 80,
                    child: Stack(
                      alignment: Alignment.center,
                      children: [
                        // Halo bleu
                        Container(
                          width: 120,
                          height: 120,
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

                        // Cercle du logo
                        Container(
                          width: 96,
                          height: 96,
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
                                color: AppTheme.primary.withOpacity(0.4),
                                blurRadius: 20,
                                offset: const Offset(0, 8),
                              ),
                            ],
                          ),
                          padding: const EdgeInsets.all(26),
                          child: SvgPicture.asset(
                            'assets/icons/school.svg',
                            colorFilter: const ColorFilter.mode(
                              Colors.white,
                              BlendMode.srcIn,
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                ),

                const SizedBox(height: 22),

                // ═══════════════════════════════════════
                // 📝 Titre + sous-titre
                // ═══════════════════════════════════════
                _FadeSlideIn(
                  delay: 140,
                  child: Text(
                    'Créer un compte',
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      fontSize: 26,
                      fontWeight: FontWeight.bold,
                      color: AppTheme.textDark(context),
                      letterSpacing: -0.5,
                    ),
                  ),
                ),

                const SizedBox(height: 8),

                _FadeSlideIn(
                  delay: 200,
                  child: Text(
                    'Créez votre espace parent École Eden',
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      fontSize: 14,
                      color: AppTheme.textMuted(context),
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                ),

                const SizedBox(height: 28),

                // ═══════════════════════════════════════
                // 👤 Section Informations personnelles
                // ═══════════════════════════════════════
                _FadeSlideIn(
                  delay: 260,
                  child: _sectionTitle(
                    title: 'Informations personnelles',
                    iconAsset: 'assets/icons/user.svg',
                  ),
                ),

                const SizedBox(height: 14),

                _FadeSlideIn(
                  delay: 300,
                  child: _card(
                    child: Column(
                      children: [
                        TextFormField(
                          controller: _nameController,
                          enabled: !_isLoading,
                          textCapitalization: TextCapitalization.words,
                          style: TextStyle(
                            color: AppTheme.textDark(context),
                            fontWeight: FontWeight.w500,
                          ),
                          decoration: _fieldDecoration(
                            label: 'Nom complet',
                            iconAsset: 'assets/icons/user.svg',
                          ),
                          validator: (value) {
                            if (value == null || value.trim().isEmpty) {
                              return 'Veuillez saisir votre nom';
                            }
                            return null;
                          },
                        ),

                        const SizedBox(height: 14),

                        TextFormField(
                          controller: _phoneController,
                          enabled: !_isLoading,
                          keyboardType: TextInputType.phone,
                          style: TextStyle(
                            color: AppTheme.textDark(context),
                            fontWeight: FontWeight.w500,
                          ),
                          decoration: _fieldDecoration(
                            label: 'Numéro de téléphone',
                            iconAsset: 'assets/icons/phone.svg',
                          ),
                          validator: (value) {
                            if (value == null || value.trim().isEmpty) {
                              return 'Veuillez saisir votre numéro';
                            }
                            return null;
                          },
                        ),

                        const SizedBox(height: 14),

                        TextFormField(
                          controller: _emailController,
                          enabled: !_isLoading,
                          keyboardType: TextInputType.emailAddress,
                          style: TextStyle(
                            color: AppTheme.textDark(context),
                            fontWeight: FontWeight.w500,
                          ),
                          decoration: _fieldDecoration(
                            label: 'Adresse email',
                            iconAsset: 'assets/icons/email.svg',
                          ),
                          validator: (value) {
                            if (value == null || value.trim().isEmpty) {
                              return 'Veuillez saisir votre email';
                            }
                            if (!value.contains('@')) {
                              return 'Veuillez saisir un email valide';
                            }
                            return null;
                          },
                        ),
                      ],
                    ),
                  ),
                ),

                const SizedBox(height: 20),

                // ═══════════════════════════════════════
                // 🔒 Section Sécurité du compte
                // ═══════════════════════════════════════
                _FadeSlideIn(
                  delay: 340,
                  child: _sectionTitle(
                    title: 'Sécurité du compte',
                    iconAsset: 'assets/icons/lock.svg',
                  ),
                ),

                const SizedBox(height: 14),

                _FadeSlideIn(
                  delay: 380,
                  child: _card(
                    child: Column(
                      children: [
                        TextFormField(
                          controller: _passwordController,
                          enabled: !_isLoading,
                          obscureText: _obscurePassword,
                          style: TextStyle(
                            color: AppTheme.textDark(context),
                            fontWeight: FontWeight.w500,
                          ),
                          decoration: _fieldDecoration(
                            label: 'Mot de passe',
                            iconAsset: 'assets/icons/lock.svg',
                            suffix: _eyeIcon(
                              obscure: _obscurePassword,
                              onTap: () {
                                setState(() {
                                  _obscurePassword = !_obscurePassword;
                                });
                              },
                            ),
                          ),
                          validator: (value) {
                            if (value == null || value.isEmpty) {
                              return 'Veuillez saisir un mot de passe';
                            }
                            if (value.length < 8) {
                              return 'Minimum 8 caractères';
                            }
                            return null;
                          },
                        ),

                        const SizedBox(height: 14),

                        TextFormField(
                          controller: _confirmPasswordController,
                          enabled: !_isLoading,
                          obscureText: _obscureConfirmPassword,
                          style: TextStyle(
                            color: AppTheme.textDark(context),
                            fontWeight: FontWeight.w500,
                          ),
                          decoration: _fieldDecoration(
                            label: 'Confirmer le mot de passe',
                            iconAsset: 'assets/icons/lock.svg',
                            suffix: _eyeIcon(
                              obscure: _obscureConfirmPassword,
                              onTap: () {
                                setState(() {
                                  _obscureConfirmPassword =
                                      !_obscureConfirmPassword;
                                });
                              },
                            ),
                          ),
                          validator: (value) {
                            if (value == null || value.isEmpty) {
                              return 'Veuillez confirmer le mot de passe';
                            }
                            if (value != _passwordController.text) {
                              return 'Les mots de passe ne correspondent pas';
                            }
                            return null;
                          },
                        ),
                      ],
                    ),
                  ),
                ),

                const SizedBox(height: 24),

                // ═══════════════════════════════════════
                // 🚀 Bouton principal (dégradé bleu)
                // ═══════════════════════════════════════
                _FadeSlideIn(
                  delay: 420,
                  child: _PressablePrimaryButton(
                    onTap: _isLoading ? null : _register,
                    isLoading: _isLoading,
                    child: const Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Text(
                          'Créer mon compte',
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
                ),

                const SizedBox(height: 24),

                // ═══════════════════════════════════════
                // ➖ Séparateur "OU"
                // ═══════════════════════════════════════
                _FadeSlideIn(
                  delay: 460,
                  child: Row(
                    children: [
                      Expanded(
                        child: Divider(
                          color: AppTheme.border(context),
                          thickness: 1,
                        ),
                      ),
                      Padding(
                        padding: const EdgeInsets.symmetric(horizontal: 12),
                        child: Text(
                          'OU',
                          style: TextStyle(
                            color: AppTheme.textMuted(context),
                            fontSize: 12,
                            fontWeight: FontWeight.w600,
                            letterSpacing: 1,
                          ),
                        ),
                      ),
                      Expanded(
                        child: Divider(
                          color: AppTheme.border(context),
                          thickness: 1,
                        ),
                      ),
                    ],
                  ),
                ),

                const SizedBox(height: 16),

                // ═══════════════════════════════════════
                // 🔗 Lien connexion
                // ═══════════════════════════════════════
                _FadeSlideIn(
                  delay: 500,
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
                          'Vous avez déjà un compte ?',
                          style: TextStyle(
                            color: AppTheme.textMuted(context),
                            fontWeight: FontWeight.w500,
                            fontSize: 13,
                          ),
                        ),
                        TextButton(
                          onPressed: _isLoading
                              ? null
                              : () {
                                  Navigator.pop(context);
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
                            'Se connecter',
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

                const SizedBox(height: 20),
              ],
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
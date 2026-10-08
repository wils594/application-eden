import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';

import '../../core/routes/app_routes.dart';
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

  static const Color _primary = Color(0xFF2563EB);
  static const Color _primaryDark = Color(0xFF1E40AF);
  static const Color _textDark = Color(0xFF0F172A);
  static const Color _textMuted = Color(0xFF64748B);
  static const Color _inputFill = Color(0xFFF8FAFC);
  static const Color _border = Color(0xFFE2E8F0);

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

  // ─────────────────────────────────────────────
  // Helpers UI (aucun impact sur la logique)
  // ─────────────────────────────────────────────

  Widget _svgPrefix(String asset) {
    return Padding(
      padding: const EdgeInsets.all(14),
      child: SvgPicture.asset(
        asset,
        width: 20,
        height: 20,
        colorFilter: const ColorFilter.mode(
          _textMuted,
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
        colorFilter: const ColorFilter.mode(
          _textMuted,
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
      labelStyle: const TextStyle(
        color: _textMuted,
        fontWeight: FontWeight.w500,
      ),
      floatingLabelStyle: const TextStyle(
        color: _primary,
        fontWeight: FontWeight.w600,
      ),
      filled: true,
      fillColor: _inputFill,
      prefixIcon: _svgPrefix(iconAsset),
      suffixIcon: suffix,
      contentPadding: const EdgeInsets.symmetric(
        horizontal: 16,
        vertical: 18,
      ),
      enabledBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: _border),
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(
          color: _primary,
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
          width: 32,
          height: 32,
          decoration: BoxDecoration(
            color: _primary.withOpacity(0.1),
            borderRadius: BorderRadius.circular(8),
          ),
          padding: const EdgeInsets.all(7),
          child: SvgPicture.asset(
            iconAsset,
            colorFilter: const ColorFilter.mode(
              _primary,
              BlendMode.srcIn,
            ),
          ),
        ),
        const SizedBox(width: 10),
        Text(
          title,
          style: const TextStyle(
            fontSize: 18,
            fontWeight: FontWeight.bold,
            color: _textDark,
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
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: _border),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: child,
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
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
                // ── Bouton retour ──
                Align(
                  alignment: Alignment.centerLeft,
                  child: IconButton(
                    onPressed: _isLoading
                        ? null
                        : () => Navigator.pop(context),
                    icon: SvgPicture.asset(
                      'assets/icons/arrow_left.svg',
                      width: 22,
                      height: 22,
                      colorFilter: const ColorFilter.mode(
                        _textDark,
                        BlendMode.srcIn,
                      ),
                    ),
                  ),
                ),

                const SizedBox(height: 8),

                // ── Logo + titres ──
                Center(
                  child: Container(
                    width: 96,
                    height: 96,
                    decoration: BoxDecoration(
                      gradient: const LinearGradient(
                        colors: [_primary, _primaryDark],
                        begin: Alignment.topLeft,
                        end: Alignment.bottomRight,
                      ),
                      shape: BoxShape.circle,
                      boxShadow: [
                        BoxShadow(
                          color: _primary.withOpacity(0.35),
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
                ),

                const SizedBox(height: 22),

                const Text(
                  'Créer un compte',
                  textAlign: TextAlign.center,
                  style: TextStyle(
                    fontSize: 26,
                    fontWeight: FontWeight.bold,
                    color: _textDark,
                    letterSpacing: -0.5,
                  ),
                ),

                const SizedBox(height: 8),

                const Text(
                  'Créez votre espace parent École Eden',
                  textAlign: TextAlign.center,
                  style: TextStyle(
                    fontSize: 14,
                    color: _textMuted,
                    fontWeight: FontWeight.w500,
                  ),
                ),

                const SizedBox(height: 28),

                // ── Section : Informations personnelles ──
                _sectionTitle(
                  title: 'Informations personnelles',
                  iconAsset: 'assets/icons/user.svg',
                ),

                const SizedBox(height: 14),

                _card(
                  child: Column(
                    children: [
                      TextFormField(
                        controller: _nameController,
                        enabled: !_isLoading,
                        textCapitalization: TextCapitalization.words,
                        style: const TextStyle(
                          color: _textDark,
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
                        style: const TextStyle(
                          color: _textDark,
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
                        style: const TextStyle(
                          color: _textDark,
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

                const SizedBox(height: 20),

                // ── Section : Sécurité du compte ──
                _sectionTitle(
                  title: 'Sécurité du compte',
                  iconAsset: 'assets/icons/lock.svg',
                ),

                const SizedBox(height: 14),

                _card(
                  child: Column(
                    children: [
                      TextFormField(
                        controller: _passwordController,
                        enabled: !_isLoading,
                        obscureText: _obscurePassword,
                        style: const TextStyle(
                          color: _textDark,
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
                        style: const TextStyle(
                          color: _textDark,
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

                const SizedBox(height: 24),

                // ── Bouton principal ──
                Container(
                  height: 54,
                  decoration: BoxDecoration(
                    gradient: const LinearGradient(
                      colors: [_primary, _primaryDark],
                      begin: Alignment.centerLeft,
                      end: Alignment.centerRight,
                    ),
                    borderRadius: BorderRadius.circular(14),
                    boxShadow: [
                      BoxShadow(
                        color: _primary.withOpacity(0.35),
                        blurRadius: 16,
                        offset: const Offset(0, 8),
                      ),
                    ],
                  ),
                  child: Material(
                    color: Colors.transparent,
                    child: InkWell(
                      borderRadius: BorderRadius.circular(14),
                      onTap: _isLoading ? null : _register,
                      child: Center(
                        child: _isLoading
                            ? const SizedBox(
                                width: 24,
                                height: 24,
                                child: CircularProgressIndicator(
                                  strokeWidth: 2.5,
                                  color: Colors.white,
                                ),
                              )
                            : const Text(
                                'Créer mon compte',
                                style: TextStyle(
                                  fontSize: 16,
                                  fontWeight: FontWeight.bold,
                                  color: Colors.white,
                                  letterSpacing: 0.3,
                                ),
                              ),
                      ),
                    ),
                  ),
                ),

                const SizedBox(height: 24),

                // ── Séparateur "OU" ──
                Row(
                  children: [
                    const Expanded(
                      child: Divider(color: _border, thickness: 1),
                    ),
                    Padding(
                      padding: const EdgeInsets.symmetric(horizontal: 12),
                      child: Text(
                        'OU',
                        style: TextStyle(
                          color: _textMuted,
                          fontSize: 12,
                          fontWeight: FontWeight.w600,
                          letterSpacing: 1,
                        ),
                      ),
                    ),
                    const Expanded(
                      child: Divider(color: _border, thickness: 1),
                    ),
                  ],
                ),

                const SizedBox(height: 16),

                // ── Lien connexion ──
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    const Text(
                      'Vous avez déjà un compte ?',
                      style: TextStyle(
                        color: _textMuted,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                    TextButton(
                      onPressed: _isLoading
                          ? null
                          : () {
                              Navigator.pop(context);
                            },
                      child: const Text(
                        'Se connecter',
                        style: TextStyle(
                          color: _primary,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                    ),
                  ],
                ),

                const SizedBox(height: 15),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
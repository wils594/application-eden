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
      ),
      filled: true,
      fillColor: _inputFill,
      prefixIcon: _svgPrefix(iconAsset),
      suffixIcon: suffix,
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
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
                const SizedBox(height: 25),

                Center(
                  child: Container(
                    width: 90,
                    height: 90,
                    decoration: BoxDecoration(
                      color: _primary.withOpacity(0.08),
                      shape: BoxShape.circle,
                    ),
                    padding: const EdgeInsets.all(20),
                    child: SvgPicture.asset(
                      'assets/icons/school.svg',
                      colorFilter: const ColorFilter.mode(
                        _primary,
                        BlendMode.srcIn,
                      ),
                    ),
                  ),
                ),

                const SizedBox(height: 20),

                const Text(
                  'Créer un compte',
                  textAlign: TextAlign.center,
                  style: TextStyle(
                    fontSize: 28,
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
                    fontSize: 15,
                    color: _textMuted,
                    fontWeight: FontWeight.w500,
                  ),
                ),

                const SizedBox(height: 35),

                const Text(
                  'Informations personnelles',
                  style: TextStyle(
                    fontSize: 20,
                    fontWeight: FontWeight.bold,
                    color: _textDark,
                  ),
                ),

                const SizedBox(height: 18),

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

                const SizedBox(height: 16),

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

                const SizedBox(height: 16),

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

                const SizedBox(height: 28),

                const Text(
                  'Sécurité du compte',
                  style: TextStyle(
                    fontSize: 20,
                    fontWeight: FontWeight.bold,
                    color: _textDark,
                  ),
                ),

                const SizedBox(height: 18),

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
                          _obscurePassword =
                              !_obscurePassword;
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

                const SizedBox(height: 16),

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

                const SizedBox(height: 28),

                Container(
                  height: 52,
                  decoration: BoxDecoration(
                    gradient: const LinearGradient(
                      colors: [
                        _primary,
                        _primaryDark,
                      ],
                      begin: Alignment.centerLeft,
                      end: Alignment.centerRight,
                    ),
                    borderRadius: BorderRadius.circular(12),
                    boxShadow: [
                      BoxShadow(
                        color: _primary.withOpacity(0.3),
                        blurRadius: 12,
                        offset: const Offset(0, 6),
                      ),
                    ],
                  ),
                  child: Material(
                    color: Colors.transparent,
                    child: InkWell(
                      borderRadius: BorderRadius.circular(12),
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

                const SizedBox(height: 20),

                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    const Text(
                      'Vous avez déjà un compte ?',
                      style: TextStyle(
                        color: _textMuted,
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
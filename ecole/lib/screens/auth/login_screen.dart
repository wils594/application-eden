import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';

import '../../core/routes/app_routes.dart';
import '../../services/auth_service.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _formKey = GlobalKey<FormState>();

  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();

  bool _obscurePassword = true;
  bool _isLoading = false;

  static const Color _primary = Color(0xFF2563EB);
  static const Color _primaryDark = Color(0xFF1E40AF);
  static const Color _textDark = Color(0xFF0F172A);
  static const Color _textMuted = Color(0xFF64748B);
  static const Color _inputFill = Color(0xFFF8FAFC);

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
                const SizedBox(height: 40),

                Center(
                  child: Container(
                    width: 100,
                    height: 100,
                    decoration: BoxDecoration(
                      color: _primary.withOpacity(0.08),
                      shape: BoxShape.circle,
                    ),
                    padding: const EdgeInsets.all(22),
                    child: SvgPicture.asset(
                      'assets/icons/school.svg',
                      colorFilter: const ColorFilter.mode(
                        _primary,
                        BlendMode.srcIn,
                      ),
                    ),
                  ),
                ),

                const SizedBox(height: 24),

                const Text(
                  'École Eden',
                  textAlign: TextAlign.center,
                  style: TextStyle(
                    fontSize: 30,
                    fontWeight: FontWeight.bold,
                    color: _textDark,
                    letterSpacing: -0.5,
                  ),
                ),

                const SizedBox(height: 8),

                const Text(
                  'Espace Parent',
                  textAlign: TextAlign.center,
                  style: TextStyle(
                    fontSize: 16,
                    color: _textMuted,
                    fontWeight: FontWeight.w500,
                  ),
                ),

                const SizedBox(height: 45),

                const Text(
                  'Connexion',
                  style: TextStyle(
                    fontSize: 24,
                    fontWeight: FontWeight.bold,
                    color: _textDark,
                  ),
                ),

                const SizedBox(height: 20),

                TextFormField(
                  controller: _emailController,
                  keyboardType: TextInputType.emailAddress,
                  enabled: !_isLoading,
                  style: const TextStyle(
                    color: _textDark,
                    fontWeight: FontWeight.w500,
                  ),
                  decoration: InputDecoration(
                    labelText: 'Email ou téléphone',
                    labelStyle: const TextStyle(
                      color: _textMuted,
                    ),
                    filled: true,
                    fillColor: _inputFill,
                    prefixIcon: Padding(
                      padding: const EdgeInsets.all(14),
                      child: SvgPicture.asset(
                        'assets/icons/email.svg',
                        width: 20,
                        height: 20,
                        colorFilter: const ColorFilter.mode(
                          _textMuted,
                          BlendMode.srcIn,
                        ),
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

                TextFormField(
                  controller: _passwordController,
                  obscureText: _obscurePassword,
                  enabled: !_isLoading,
                  style: const TextStyle(
                    color: _textDark,
                    fontWeight: FontWeight.w500,
                  ),
                  decoration: InputDecoration(
                    labelText: 'Mot de passe',
                    labelStyle: const TextStyle(
                      color: _textMuted,
                    ),
                    filled: true,
                    fillColor: _inputFill,
                    prefixIcon: Padding(
                      padding: const EdgeInsets.all(14),
                      child: SvgPicture.asset(
                        'assets/icons/lock.svg',
                        width: 20,
                        height: 20,
                        colorFilter: const ColorFilter.mode(
                          _textMuted,
                          BlendMode.srcIn,
                        ),
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
                      icon: SvgPicture.asset(
                        _obscurePassword
                            ? 'assets/icons/eye.svg'
                            : 'assets/icons/eye_off.svg',
                        width: 20,
                        height: 20,
                        colorFilter: const ColorFilter.mode(
                          _textMuted,
                          BlendMode.srcIn,
                        ),
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

                const SizedBox(height: 12),

                Align(
                  alignment: Alignment.centerRight,
                  child: TextButton(
                    onPressed: _isLoading
                        ? null
                        : () {
                            // À développer plus tard.
                          },
                    style: TextButton.styleFrom(
                      foregroundColor: _primary,
                    ),
                    child: const Text(
                      'Mot de passe oublié ?',
                      style: TextStyle(
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ),
                ),

                const SizedBox(height: 20),

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
                      onTap: _isLoading ? null : _login,
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
                                'Se connecter',
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

                Wrap(
                  alignment: WrapAlignment.center,
                  crossAxisAlignment: WrapCrossAlignment.center,
                  children: [
                    const Text(
                      'Vous n’avez pas encore de compte ?',
                      style: TextStyle(
                        color: _textMuted,
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
                      child: const Text(
                        'Créer un compte',
                        style: TextStyle(
                          color: _primary,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                    ),
                  ],
                ),

                const SizedBox(height: 30),

                const Text(
                  'École Eden • Espace Parent',
                  textAlign: TextAlign.center,
                  style: TextStyle(
                    color: _textMuted,
                    fontSize: 13,
                    fontWeight: FontWeight.w500,
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}

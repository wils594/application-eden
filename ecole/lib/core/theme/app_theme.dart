import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';

class AppTheme {
  // ═════════════════════════════════════════════
  // 🎨 PALETTE CENTRALISÉE — BLEU
  // ═════════════════════════════════════════════
  static const Color primary = Color(0xFF2563EB);
  static const Color primaryDark = Color(0xFF1D4ED8);
  static const Color primarySoft = Color(0xFFEFF6FF);

  // Light
  static const Color _lightBg = Color(0xFFFAFAFA);
  static const Color _lightSurface = Colors.white;
  static const Color _lightText = Color(0xFF1F2937);
  static const Color _lightTextMuted = Color(0xFF6B7280);
  static const Color _lightBorder = Color(0xFFE5E7EB);

  // Dark
  static const Color _darkBg = Color(0xFF121212);
  static const Color _darkSurface = Color(0xFF1E1E1E);
  static const Color _darkSurfaceAlt = Color(0xFF252525);
  static const Color _darkText = Color(0xFFF9FAFB);
  static const Color _darkTextMuted = Color(0xFF9CA3AF);
  static const Color _darkBorder = Color(0xFF383838);
  static const Color _darkPrimarySoft = Color(0xFF1E3A8A);

  // ── Clé de stockage ──
  static const String _darkModeKey = 'ecole_eden_dark_mode';

  // ── Notifier global ──
  static final ValueNotifier<bool> isDarkMode =
      ValueNotifier<bool>(false);

  // ── Chargement / sauvegarde ──
  static Future<void> loadSavedTheme() async {
    final preferences = await SharedPreferences.getInstance();
    isDarkMode.value = preferences.getBool(_darkModeKey) ?? false;
  }

  static Future<void> setDarkMode(bool enabled) async {
    isDarkMode.value = enabled;
    final preferences = await SharedPreferences.getInstance();
    await preferences.setBool(_darkModeKey, enabled);
  }

  // ═════════════════════════════════════════════
  // ☀️ LIGHT THEME
  // ═════════════════════════════════════════════
  static ThemeData get lightTheme {
    return ThemeData(
      useMaterial3: true,
      brightness: Brightness.light,
      colorScheme: ColorScheme.fromSeed(
        seedColor: primary,
        brightness: Brightness.light,
        surface: _lightSurface,
        onSurface: _lightText,
        onSurfaceVariant: _lightTextMuted,
        surfaceContainerHighest: primarySoft,
        outline: _lightBorder,
      ),
      scaffoldBackgroundColor: _lightBg,
      appBarTheme: const AppBarTheme(
        backgroundColor: _lightSurface,
        foregroundColor: _lightText,
        centerTitle: true,
        elevation: 0,
      ),
      cardColor: _lightSurface,
      dividerColor: _lightBorder,
      inputDecorationTheme: InputDecorationTheme(
        filled: true,
        fillColor: _lightSurface,
        border: _roundedBorder,
        enabledBorder: _roundedBorder.copyWith(
          borderSide: const BorderSide(color: _lightBorder),
        ),
        focusedBorder: _roundedBorder.copyWith(
          borderSide: const BorderSide(
            color: primary,
            width: 1.5,
          ),
        ),
      ),
      elevatedButtonTheme: ElevatedButtonThemeData(
        style: ElevatedButton.styleFrom(
          minimumSize: const Size(double.infinity, 50),
          backgroundColor: primary,
          foregroundColor: Colors.white,
          shape: _roundedShape,
        ),
      ),
      switchTheme: SwitchThemeData(
        thumbColor: WidgetStateProperty.resolveWith((states) {
          if (states.contains(WidgetState.selected)) {
            return Colors.white;
          }
          return null;
        }),
        trackColor: WidgetStateProperty.resolveWith((states) {
          if (states.contains(WidgetState.selected)) {
            return primary;
          }
          return null;
        }),
      ),
    );
  }

  // ═════════════════════════════════════════════
  // 🌙 DARK THEME
  // ═════════════════════════════════════════════
  static ThemeData get darkTheme {
    return ThemeData(
      useMaterial3: true,
      brightness: Brightness.dark,
      colorScheme: ColorScheme.fromSeed(
        seedColor: primary,
        brightness: Brightness.dark,
        surface: _darkSurface,
        onSurface: _darkText,
        onSurfaceVariant: _darkTextMuted,
        surfaceContainerHighest: _darkSurfaceAlt,
        outline: _darkBorder,
      ),
      scaffoldBackgroundColor: _darkBg,
      appBarTheme: const AppBarTheme(
        backgroundColor: Color(0xFF1A1A1A),
        foregroundColor: Colors.white,
        centerTitle: true,
        elevation: 0,
      ),
      cardColor: _darkSurface,
      dividerColor: _darkBorder,
      inputDecorationTheme: InputDecorationTheme(
        filled: true,
        fillColor: _darkSurfaceAlt,
        border: _roundedBorder,
        enabledBorder: _roundedBorder.copyWith(
          borderSide: const BorderSide(color: _darkBorder),
        ),
        focusedBorder: _roundedBorder.copyWith(
          borderSide: const BorderSide(
            color: primary,
            width: 1.5,
          ),
        ),
      ),
      elevatedButtonTheme: ElevatedButtonThemeData(
        style: ElevatedButton.styleFrom(
          minimumSize: const Size(double.infinity, 50),
          backgroundColor: primary,
          foregroundColor: Colors.white,
          shape: _roundedShape,
        ),
      ),
      switchTheme: SwitchThemeData(
        thumbColor: WidgetStateProperty.resolveWith((states) {
          if (states.contains(WidgetState.selected)) {
            return Colors.white;
          }
          return null;
        }),
        trackColor: WidgetStateProperty.resolveWith((states) {
          if (states.contains(WidgetState.selected)) {
            return primary;
          }
          return null;
        }),
      ),
    );
  }

  // ═════════════════════════════════════════════
  // 🎯 HELPERS PARTAGÉS
  // ═════════════════════════════════════════════

  static final _roundedBorder = OutlineInputBorder(
    borderRadius: BorderRadius.circular(12),
  );

  static final _roundedShape = RoundedRectangleBorder(
    borderRadius: BorderRadius.circular(12),
  );

  // ═════════════════════════════════════════════
  // 🛠️ UTILITAIRES POUR LES ÉCRANS
  // ═════════════════════════════════════════════

  /// Retourne true si le mode sombre est actif.
  static bool isDark(BuildContext context) {
    return Theme.of(context).brightness == Brightness.dark;
  }

  /// Retourne la couleur de surface "carte" (blanc en light, sombre en dark).
  static Color cardColor(BuildContext context) {
    return isDark(context) ? _darkSurface : Colors.white;
  }

  /// Retourne la couleur de fond bleu pâle adaptée au thème.
  static Color primarySoftColor(BuildContext context) {
    return isDark(context) ? _darkPrimarySoft : primarySoft;
  }

  /// Retourne la couleur de bordure adaptée au mode.
  static Color border(BuildContext context) {
    return isDark(context) ? _darkBorder : _lightBorder;
  }

  /// Retourne la couleur de texte principale.
  static Color textDark(BuildContext context) {
    return isDark(context) ? _darkText : _lightText;
  }

  /// Retourne la couleur de texte secondaire.
  static Color textMuted(BuildContext context) {
    return isDark(context) ? _darkTextMuted : _lightTextMuted;
  }
}
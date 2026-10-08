import 'package:flutter/material.dart';

class AppTheme {
  static ThemeData lightTheme = ThemeData(
    useMaterial3: true,

    colorScheme: ColorScheme.fromSeed(
      seedColor: Colors.blue,
    ),

    scaffoldBackgroundColor: Colors.white,

    appBarTheme: const AppBarTheme(
      centerTitle: true,
      elevation: 0,
    ),

    inputDecorationTheme: InputDecorationTheme(
      border: _roundedBorder,
      enabledBorder: _roundedBorder,
      focusedBorder: _roundedBorder,
    ),

    elevatedButtonTheme: ElevatedButtonThemeData(
      style: ElevatedButton.styleFrom(
        minimumSize: const Size(double.infinity, 50),
        shape: _roundedShape,
      ),
    ),
  );

  static final _roundedBorder = OutlineInputBorder(
    borderRadius: BorderRadius.circular(12),
  );

  static final _roundedShape = RoundedRectangleBorder(
    borderRadius: BorderRadius.circular(12),
  );
}
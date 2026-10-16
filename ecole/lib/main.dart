
import 'package:flutter/material.dart';

import 'core/routes/app_routes.dart';
import 'core/theme/app_theme.dart';

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();

  await AppTheme.loadSavedTheme();

  runApp(const EcoleEdenApp());
}

class EcoleEdenApp extends StatelessWidget {
  const EcoleEdenApp({super.key});

  static const String _appTitle = 'École Eden';

  @override
  Widget build(BuildContext context) {
    return ValueListenableBuilder<bool>(
      valueListenable: AppTheme.isDarkMode,
      builder: (context, isDark, child) {
        return MaterialApp(
          debugShowCheckedModeBanner: false,
          title: _appTitle,
          theme: AppTheme.lightTheme,
          darkTheme: AppTheme.darkTheme,
          themeMode: isDark ? ThemeMode.dark : ThemeMode.light,
          initialRoute: AppRoutes.login,
          onGenerateRoute: AppRoutes.generateRoute,
        );
      },
    );
  }
}

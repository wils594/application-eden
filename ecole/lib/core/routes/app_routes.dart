import 'package:flutter/material.dart';

import '../../screens/auth/login_screen.dart';
import '../../screens/auth/register_screen.dart';
import '../../screens/home/home_screen.dart';
import '../../screens/enfants/enfants_screen.dart';
import '../../screens/bulletins/bulletins_screen.dart';
import '../../screens/annonces/annonces_screen.dart';
import '../../screens/chat/chat_screen.dart';
import '../../screens/profil/profile_screen.dart';
import '../../screens/reglages/reglages_screen.dart';

class AppRoutes {
  static const String login = '/login';
  static const String register = '/register';
  static const String home = '/home';
  static const String enfants = '/enfants';
  static const String bulletins = '/bulletins';
  static const String annonces = '/annonces';
  static const String chat = '/chat';
  static const String profil = '/profil';
  static const String reglages = '/reglages';

  static Route<dynamic> generateRoute(RouteSettings settings) {
    switch (settings.name) {
      case login:
        return MaterialPageRoute(
          builder: (_) => const LoginScreen(),
        );

      case register:
        return MaterialPageRoute(
          builder: (_) => const RegisterScreen(),
        );

      case home:
        return MaterialPageRoute(
          builder: (_) => const HomeScreen(),
        );

      case enfants:
        return MaterialPageRoute(
          builder: (_) => const EnfantsScreen(),
        );

      case bulletins:
        return MaterialPageRoute(
          builder: (_) => const BulletinsScreen(),
        );

      case annonces:
        return MaterialPageRoute(
          builder: (_) => const AnnoncesScreen(),
        );

      case chat:
        return MaterialPageRoute(
          builder: (_) => const ChatScreen(),
        );

      case profil:
        return MaterialPageRoute(
          builder: (_) => const ProfileScreen(),
        );

      case reglages:
        return MaterialPageRoute(
          builder: (_) => const ReglagesScreen(),
        );

      default:
        return MaterialPageRoute(
          builder: (_) => Scaffold(
            appBar: AppBar(title: const Text('Page introuvable')),
            body: Center(
              child: Text(
                'Route inconnue : ${settings.name}',
                textAlign: TextAlign.center,
              ),
            ),
          ),
        );
    }
  }
}
import 'api_service.dart';

class AuthService {
  static Future<Map<String, dynamic>> login({
    required String login,
    required String password,
  }) async {
    return await ApiService.post(
      '/login',
      {
        'login': login,
        'password': password,
      },
    );
  }

  static Future<Map<String, dynamic>> register({
    required String name,
    required String phone,
    required String email,
    required String password,
    required String passwordConfirmation,
  }) async {
    return await ApiService.post(
      '/register',
      {
        'name': name,
        'phone': phone,
        'email': email,
        'password': password,
        'password_confirmation': passwordConfirmation,
      },
    );
  }
}
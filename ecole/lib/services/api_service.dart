import 'dart:convert';

import 'package:http/http.dart' as http;

import '../core/constants/app_constants.dart';

class ApiService {
  static Future<Map<String, dynamic>> post(
    String endpoint,
    Map<String, dynamic> data,
  ) async {
    final response = await http.post(
      Uri.parse('${AppConstants.apiBaseUrl}$endpoint'),
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: jsonEncode(data),
    );

    final responseData = jsonDecode(response.body);

    if (response.statusCode >= 200 && response.statusCode < 300) {
      return Map<String, dynamic>.from(responseData);
    }

    throw Exception(
      responseData['message'] ?? 'Une erreur est survenue.',
    );
  }
}
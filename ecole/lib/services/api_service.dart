
import 'dart:convert';
import 'dart:io';
import 'dart:typed_data';

import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

import '../core/constants/app_constants.dart';

class ApiService {
  // Envoyer des données à l'API Laravel.
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

    final responseData = _decodeJsonResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      final result = responseData;

      // Enregistrer le jeton reçu après la connexion.
      if (result['token'] != null) {
        final prefs = await SharedPreferences.getInstance();

        await prefs.setString(
          'auth_token',
          result['token'].toString(),
        );
      }

      return result;
    }

    throw Exception(
      responseData['message'] ?? 'Une erreur est survenue.',
    );
  }

  // Récupérer des données depuis l'API Laravel.
  static Future<Map<String, dynamic>> get(
    String endpoint,
  ) async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('auth_token');

    if (token == null || token.isEmpty) {
      throw Exception(
        'Vous devez vous connecter à nouveau.',
      );
    }

    final response = await http.get(
      Uri.parse('${AppConstants.apiBaseUrl}$endpoint'),
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    final responseData = _decodeJsonResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return responseData;
    }

    throw Exception(
      responseData['message'] ?? 'Une erreur est survenue.',
    );
  }

  // Récupérer le PDF d'un bulletin pour le consulter
  // ou l'enregistrer avec le sélecteur de fichiers.
  static Future<Uint8List> fetchBulletinPdf(
    int bulletinId,
  ) async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('auth_token');

    if (token == null || token.isEmpty) {
      throw Exception(
        'Vous devez vous connecter à nouveau.',
      );
    }

    final response = await http.get(
      Uri.parse(
        '${AppConstants.apiBaseUrl}/bulletins/$bulletinId/telecharger',
      ),
      headers: {
        'Accept': 'application/pdf',
        'Authorization': 'Bearer $token',
      },
    );

    if (response.statusCode != 200) {
      String message =
          'Impossible de récupérer le bulletin '
          '(HTTP ${response.statusCode}).';

      try {
        final errorData = jsonDecode(
          utf8.decode(response.bodyBytes),
        );

        if (errorData is Map &&
            errorData['message'] != null) {
          message = errorData['message'].toString();
        }
      } catch (_) {
        // La réponse d'erreur n'est pas forcément du JSON.
      }

      throw Exception(message);
    }

    return response.bodyBytes;
  }

  // Télécharger le bulletin dans un fichier temporaire.
  // Cette méthode conserve la fonctionnalité existante.
  static Future<String> downloadBulletin(
    int bulletinId,
  ) async {
    final bytes = await fetchBulletinPdf(bulletinId);

    final directory = await Directory.systemTemp.createTemp(
      'eden_bulletin_',
    );

    final file = File(
      '${directory.path}/bulletin-$bulletinId.pdf',
    );

    await file.writeAsBytes(bytes, flush: true);

    return file.path;
  }

  // Décoder proprement les réponses JSON de Laravel.
  static Map<String, dynamic> _decodeJsonResponse(
    http.Response response,
  ) {
    try {
      final decoded = jsonDecode(
        utf8.decode(response.bodyBytes),
      );

      if (decoded is Map) {
        return Map<String, dynamic>.from(decoded);
      }

      throw const FormatException(
        'La réponse du serveur est invalide.',
      );
    } catch (_) {
      throw Exception(
        'Réponse invalide du serveur '
        '(HTTP ${response.statusCode}).',
      );
    }
  }
}

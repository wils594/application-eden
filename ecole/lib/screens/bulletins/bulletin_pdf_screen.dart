import 'dart:typed_data';

import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:pdfrx/pdfrx.dart';

class BulletinPdfScreen extends StatelessWidget {
  final Uint8List pdfBytes;
  final String title;

  const BulletinPdfScreen({
    super.key,
    required this.pdfBytes,
    required this.title,
  });

  // Palette cohérente avec le reste de l'app
  static const Color primary = Color(0xFF2563EB);
  static const Color primaryDark = Color(0xFF1D4ED8);
  static const Color textDark = Color(0xFF111827);
  static const Color textMuted = Color(0xFF6B7280);
  static const Color primarySoft = Color(0xFFEFF6FF);

  /// Helper SVG teinté
  Widget _svg({
    required String asset,
    Color color = textDark,
    double size = 22,
  }) {
    return SvgPicture.asset(
      asset,
      width: size,
      height: size,
      colorFilter: ColorFilter.mode(color, BlendMode.srcIn),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF3F5F9),

      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0,
        scrolledUnderElevation: 0,
        centerTitle: false,
        titleSpacing: 8,

        leading: IconButton(
          tooltip: 'Retour',
          onPressed: () => Navigator.pop(context),
          icon: _svg(
            asset: 'assets/icons/arrow_left.svg',
            color: textDark,
            size: 22,
          ),
        ),

        title: Row(
          children: [
            // Logo dégradé
            Container(
              width: 38,
              height: 38,
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [primary, primaryDark],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),
                borderRadius: BorderRadius.circular(10),
                boxShadow: [
                  BoxShadow(
                    color: primary.withOpacity(0.25),
                    blurRadius: 8,
                    offset: const Offset(0, 3),
                  ),
                ],
              ),
              padding: const EdgeInsets.all(9),
              child: SvgPicture.asset(
                'assets/icons/file-text.svg',
                colorFilter: const ColorFilter.mode(
                  Colors.white,
                  BlendMode.srcIn,
                ),
              ),
            ),

            const SizedBox(width: 12),

            Expanded(
              child: Text(
                title,
                maxLines: 1,
                overflow: TextOverflow.ellipsis,
                style: const TextStyle(
                  color: textDark,
                  fontSize: 16,
                  fontWeight: FontWeight.bold,
                  letterSpacing: -0.3,
                ),
              ),
            ),
          ],
        ),
      ),

      body: PdfViewer.data(
        pdfBytes,
        sourceName: '$title.pdf',
        params: PdfViewerParams(
          backgroundColor: const Color(0xFFF3F5F9),

          loadingBannerBuilder: (
            context,
            bytesDownloaded,
            totalBytes,
          ) {
            return Center(
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  // Double cercle + SVG fichier
                  Container(
                    width: 110,
                    height: 110,
                    decoration: BoxDecoration(
                      color: primarySoft,
                      shape: BoxShape.circle,
                    ),
                    alignment: Alignment.center,
                    child: Container(
                      width: 78,
                      height: 78,
                      decoration: BoxDecoration(
                        color: Colors.white,
                        shape: BoxShape.circle,
                        boxShadow: [
                          BoxShadow(
                            color: primary.withOpacity(0.15),
                            blurRadius: 14,
                            offset: const Offset(0, 5),
                          ),
                        ],
                      ),
                      padding: const EdgeInsets.all(20),
                      child: _svg(
                        asset: 'assets/icons/file-text.svg',
                        color: primary,
                        size: 38,
                      ),
                    ),
                  ),

                  const SizedBox(height: 24),

                  // Spinner bleu
                  const SizedBox(
                    width: 28,
                    height: 28,
                    child: CircularProgressIndicator(
                      strokeWidth: 2.5,
                      color: primary,
                    ),
                  ),

                  const SizedBox(height: 18),

                  const Text(
                    'Chargement du bulletin PDF...',
                    style: TextStyle(
                      color: textDark,
                      fontSize: 14,
                      fontWeight: FontWeight.w600,
                      letterSpacing: -0.2,
                    ),
                  ),

                  const SizedBox(height: 6),

                  const Text(
                    'Le document sera bientôt affiché.',
                    style: TextStyle(
                      color: textMuted,
                      fontSize: 12.5,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                ],
              ),
            );
          },

          errorBannerBuilder: (
            context,
            error,
            stackTrace,
            documentRef,
          ) {
            return Center(
              child: Padding(
                padding: const EdgeInsets.all(24),
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    // Cercle rouge clair + SVG file-x
                    Container(
                      width: 96,
                      height: 96,
                      decoration: const BoxDecoration(
                        color: Color(0xFFFEF2F2),
                        shape: BoxShape.circle,
                      ),
                      alignment: Alignment.center,
                      child: _svg(
                        asset: 'assets/icons/file-x.svg',
                        color: Colors.red.shade700,
                        size: 42,
                      ),
                    ),

                    const SizedBox(height: 22),

                    const Text(
                      'Impossible d’afficher le bulletin',
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        color: textDark,
                        fontSize: 17,
                        fontWeight: FontWeight.bold,
                        letterSpacing: -0.3,
                      ),
                    ),

                    const SizedBox(height: 10),

                    Text(
                      '$error',
                      textAlign: TextAlign.center,
                      style: const TextStyle(
                        color: textMuted,
                        fontSize: 13.5,
                        height: 1.5,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                  ],
                ),
              ),
            );
          },
        ),
      ),
    );
  }
}
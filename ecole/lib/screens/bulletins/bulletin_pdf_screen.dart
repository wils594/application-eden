import 'dart:typed_data';

import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:pdfrx/pdfrx.dart';
import 'package:ecole_eden/core/theme/app_theme.dart';

class BulletinPdfScreen extends StatelessWidget {
  final Uint8List pdfBytes;
  final String title;

  const BulletinPdfScreen({
    super.key,
    required this.pdfBytes,
    required this.title,
  });

  // ═════════════════════════════════════════════
  // 🎨 COULEURS DE MARQUE — BLEU
  // ═════════════════════════════════════════════
  static const Color primary = Color(0xFF2563EB);
  static const Color primaryDark = Color(0xFF1D4ED8);

  /// Helper SVG teinté
  Widget _svg({
    required String asset,
    required Color color,
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
    // ═══════════════════════════════════════════
    // 🎨 COULEURS DYNAMIQUES (light / dark)
    // ═══════════════════════════════════════════
    final textDark = AppTheme.textDark(context);
    final textMuted = AppTheme.textMuted(context);
    final background = Theme.of(context).scaffoldBackgroundColor;
    final cardColor = AppTheme.cardColor(context);
    final primarySoft = AppTheme.primarySoftColor(context);
    final appBarColor =
        Theme.of(context).appBarTheme.backgroundColor ?? cardColor;

    return Scaffold(
      backgroundColor: background,

      appBar: AppBar(
        backgroundColor: appBarColor,
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
            // ── Logo dégradé bleu ──
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
                    color: primary.withOpacity(0.3),
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
                style: TextStyle(
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
          backgroundColor: background,

          loadingBannerBuilder: (
            context,
            bytesDownloaded,
            totalBytes,
          ) {
            return Center(
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  // Double cercle bleu + SVG fichier
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
                        color: cardColor,
                        shape: BoxShape.circle,
                        boxShadow: [
                          BoxShadow(
                            color: primary.withOpacity(0.2),
                            blurRadius: 14,
                            offset: const Offset(0, 5),
                          ),
                        ],
                      ),
                      padding: const EdgeInsets.all(20),
                      child: _svg(
                        asset: 'assets/icons/file-text.svg',
                        color: primaryDark,
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

                  Text(
                    'Chargement du bulletin PDF...',
                    style: TextStyle(
                      color: textDark,
                      fontSize: 14,
                      fontWeight: FontWeight.w600,
                      letterSpacing: -0.2,
                    ),
                  ),

                  const SizedBox(height: 6),

                  Text(
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

                    Text(
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
                      style: TextStyle(
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
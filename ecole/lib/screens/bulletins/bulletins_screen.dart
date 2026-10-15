
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:flutter_file_dialog/flutter_file_dialog.dart';

import '../../services/api_service.dart';
import 'bulletin_pdf_screen.dart';

class BulletinsScreen extends StatefulWidget {
  const BulletinsScreen({super.key});

  @override
  State<BulletinsScreen> createState() => _BulletinsScreenState();
}

class _BulletinsScreenState extends State<BulletinsScreen> {
  bool _isLoading = true;
  bool _isSaving = false;
  String? _error;
  List<Map<String, dynamic>> _bulletins = [];

  // Palette de couleurs de l'application.
  static const Color primary = Color(0xFF2563EB);
  static const Color primaryDark = Color(0xFF1D4ED8);
  static const Color textDark = Color(0xFF111827);
  static const Color textMuted = Color(0xFF6B7280);
  static const Color background = Color(0xFFF7F9FC);
  static const Color border = Color(0xFFE5E7EB);
  static const Color primarySoft = Color(0xFFEFF6FF);

  @override
  void initState() {
    super.initState();
    _loadBulletins();
  }

  // --------------------------------------------------
  // Charger les bulletins depuis l'API Laravel.
  // --------------------------------------------------

  Future<void> _loadBulletins() async {
    if (!mounted) return;

    setState(() {
      _isLoading = true;
      _error = null;
    });

    try {
      final response = await ApiService.get('/bulletins');
      final items = response['bulletins'] as List? ?? [];

      if (!mounted) return;

      setState(() {
        _bulletins = items
            .map((item) => Map<String, dynamic>.from(item))
            .toList();
        _isLoading = false;
      });
    } catch (e) {
      if (!mounted) return;

      setState(() {
        _error = e.toString().replaceFirst('Exception: ', '');
        _isLoading = false;
      });
    }
  }

  // --------------------------------------------------
  // Consulter le bulletin dans l'application.
  // --------------------------------------------------

  Future<void> _viewBulletin(
    Map<String, dynamic> bulletin,
  ) async {
    try {
      final id = int.parse(bulletin['id'].toString());

      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Chargement du bulletin...'),
          duration: Duration(seconds: 2),
        ),
      );

      final bytes = await ApiService.fetchBulletinPdf(id);

      if (!mounted) return;

      final student =
          (bulletin['student_name'] ?? 'Élève').toString();

      final title = 'Bulletin - $student';

      await Navigator.of(context).push(
        MaterialPageRoute(
          builder: (_) => BulletinPdfScreen(
            pdfBytes: bytes,
            title: title,
          ),
        ),
      );
    } catch (e) {
      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Erreur lors de l’ouverture : $e'),
          duration: const Duration(seconds: 5),
        ),
      );
    }
  }

  // --------------------------------------------------
  // Enregistrer le PDF dans un emplacement choisi.
  // --------------------------------------------------

  Future<void> _saveBulletin(
    Map<String, dynamic> bulletin,
  ) async {
    if (_isSaving) return;

    setState(() {
      _isSaving = true;
    });

    try {
      final id = int.parse(bulletin['id'].toString());

      final bytes = await ApiService.fetchBulletinPdf(id);

      if (!mounted) return;

      final student = (bulletin['student_name'] ?? 'eleve')
          .toString()
          .replaceAll(RegExp(r'[\\/:*?"<>|]'), '_');

      final fileName = 'Bulletin_$student.pdf';

      final savedPath = await FlutterFileDialog.saveFile(
        params: SaveFileDialogParams(
          data: bytes,
          fileName: fileName,
          mimeTypesFilter: ['application/pdf'],
        ),
      );

      if (!mounted) return;

      if (savedPath == null) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(
            content: Text('Enregistrement annulé.'),
          ),
        );
        return;
      }

      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Bulletin enregistré avec succès.'),
          duration: Duration(seconds: 4),
        ),
      );
    } catch (e) {
      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Erreur de téléchargement : $e'),
          duration: const Duration(seconds: 5),
        ),
      );
    } finally {
      if (mounted) {
        setState(() {
          _isSaving = false;
        });
      }
    }
  }

  // --------------------------------------------------
  // Afficher une icône SVG teintée.
  // --------------------------------------------------

  Widget _svg({
    required String asset,
    Color color = textDark,
    double size = 22,
  }) {
    return SvgPicture.asset(
      asset,
      width: size,
      height: size,
      colorFilter: ColorFilter.mode(
        color,
        BlendMode.srcIn,
      ),
    );
  }

  // --------------------------------------------------
  // En-tête principal.
  // --------------------------------------------------

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: background,
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0,
        scrolledUnderElevation: 0,
        centerTitle: false,
        titleSpacing: 20,
        title: Row(
          children: [
            Container(
              width: 42,
              height: 42,
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [primary, primaryDark],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),
                borderRadius: BorderRadius.circular(12),
                boxShadow: [
                  BoxShadow(
                    color: primary.withOpacity(0.25),
                    blurRadius: 10,
                    offset: const Offset(0, 4),
                  ),
                ],
              ),
              padding: const EdgeInsets.all(10),
              child: SvgPicture.asset(
                'assets/icons/file-text.svg',
                colorFilter: const ColorFilter.mode(
                  Colors.white,
                  BlendMode.srcIn,
                ),
              ),
            ),
            const SizedBox(width: 12),
            const Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisSize: MainAxisSize.min,
                children: [
                  Text(
                    'Mes bulletins',
                    style: TextStyle(
                      color: textDark,
                      fontSize: 17,
                      fontWeight: FontWeight.bold,
                      letterSpacing: -0.3,
                    ),
                  ),
                  SizedBox(height: 2),
                  Text(
                    'Consultez vos résultats scolaires',
                    style: TextStyle(
                      color: textMuted,
                      fontSize: 11,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
        actions: [
          IconButton(
            onPressed: _isLoading ? null : _loadBulletins,
            tooltip: 'Actualiser',
            icon: _svg(
              asset: 'assets/icons/refresh.svg',
              color: textDark,
              size: 22,
            ),
          ),
          const SizedBox(width: 8),
        ],
      ),
      body: _buildBody(),
    );
  }

  // --------------------------------------------------
  // Contenu principal.
  // --------------------------------------------------

  Widget _buildBody() {
    if (_isLoading) {
      return const Center(
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            CircularProgressIndicator(color: primary),
            SizedBox(height: 16),
            Text(
              'Chargement des bulletins...',
              style: TextStyle(
                color: textMuted,
                fontSize: 13.5,
                fontWeight: FontWeight.w500,
              ),
            ),
          ],
        ),
      );
    }

    if (_error != null) {
      return Center(
        child: Padding(
          padding: const EdgeInsets.all(24),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Container(
                width: 96,
                height: 96,
                decoration: const BoxDecoration(
                  color: Color(0xFFFEF2F2),
                  shape: BoxShape.circle,
                ),
                alignment: Alignment.center,
                child: _svg(
                  asset: 'assets/icons/cloud-off.svg',
                  color: Colors.red.shade700,
                  size: 42,
                ),
              ),
              const SizedBox(height: 22),
              const Text(
                'Impossible de charger les bulletins',
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
                _error!,
                textAlign: TextAlign.center,
                style: const TextStyle(
                  color: textMuted,
                  fontSize: 13.5,
                  height: 1.5,
                  fontWeight: FontWeight.w500,
                ),
              ),
              const SizedBox(height: 22),
              ElevatedButton.icon(
                onPressed: _loadBulletins,
                icon: const Icon(Icons.refresh),
                label: const Text('Réessayer'),
                style: ElevatedButton.styleFrom(
                  backgroundColor: primary,
                  foregroundColor: Colors.white,
                  padding: const EdgeInsets.symmetric(
                    horizontal: 22,
                    vertical: 12,
                  ),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10),
                  ),
                ),
              ),
            ],
          ),
        ),
      );
    }

    if (_bulletins.isEmpty) {
      return RefreshIndicator(
        onRefresh: _loadBulletins,
        color: primary,
        child: ListView(
          physics: const AlwaysScrollableScrollPhysics(),
          padding: const EdgeInsets.all(24),
          children: [
            const SizedBox(height: 80),
            Center(
              child: Container(
                width: 110,
                height: 110,
                decoration: const BoxDecoration(
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
            ),
            const SizedBox(height: 26),
            const Text(
              'Aucun bulletin disponible',
              textAlign: TextAlign.center,
              style: TextStyle(
                color: textDark,
                fontSize: 18,
                fontWeight: FontWeight.bold,
                letterSpacing: -0.3,
              ),
            ),
            const SizedBox(height: 10),
            const Text(
              'Les bulletins apparaîtront ici après leur publication '
              'par l’administration.',
              textAlign: TextAlign.center,
              style: TextStyle(
                color: textMuted,
                fontSize: 14,
                height: 1.6,
                fontWeight: FontWeight.w500,
              ),
            ),
          ],
        ),
      );
    }

    return RefreshIndicator(
      onRefresh: _loadBulletins,
      color: primary,
      child: ListView.separated(
        physics: const AlwaysScrollableScrollPhysics(),
        padding: const EdgeInsets.all(16),
        itemCount: _bulletins.length,
        separatorBuilder: (_, __) => const SizedBox(height: 12),
        itemBuilder: (context, index) {
          return _buildBulletinCard(_bulletins[index]);
        },
      ),
    );
  }

  // --------------------------------------------------
  // Carte de chaque bulletin.
  // --------------------------------------------------

  Widget _buildBulletinCard(
    Map<String, dynamic> bulletin,
  ) {
    final studentName =
        bulletin['student_name']?.toString() ?? 'Élève';
    final term = bulletin['term']?.toString() ?? '';
    final schoolYear = bulletin['school_year']?.toString() ?? '';

    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: border),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.04),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            Row(
              children: [
                Container(
                  width: 54,
                  height: 54,
                  decoration: BoxDecoration(
                    gradient: const LinearGradient(
                      colors: [primary, primaryDark],
                      begin: Alignment.topLeft,
                      end: Alignment.bottomRight,
                    ),
                    borderRadius: BorderRadius.circular(14),
                    boxShadow: [
                      BoxShadow(
                        color: primary.withOpacity(0.25),
                        blurRadius: 10,
                        offset: const Offset(0, 4),
                      ),
                    ],
                  ),
                  padding: const EdgeInsets.all(14),
                  child: SvgPicture.asset(
                    'assets/icons/file-text.svg',
                    colorFilter: const ColorFilter.mode(
                      Colors.white,
                      BlendMode.srcIn,
                    ),
                  ),
                ),
                const SizedBox(width: 14),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        studentName,
                        maxLines: 1,
                        overflow: TextOverflow.ellipsis,
                        style: const TextStyle(
                          color: textDark,
                          fontSize: 15.5,
                          fontWeight: FontWeight.bold,
                          letterSpacing: -0.2,
                        ),
                      ),
                      const SizedBox(height: 7),
                      Wrap(
                        crossAxisAlignment: WrapCrossAlignment.center,
                        spacing: 8,
                        runSpacing: 5,
                        children: [
                          if (term.isNotEmpty)
                            Container(
                              padding: const EdgeInsets.symmetric(
                                horizontal: 8,
                                vertical: 3,
                              ),
                              decoration: BoxDecoration(
                                color: primarySoft,
                                borderRadius: BorderRadius.circular(6),
                              ),
                              child: Text(
                                term,
                                style: const TextStyle(
                                  color: primary,
                                  fontSize: 11,
                                  fontWeight: FontWeight.w600,
                                ),
                              ),
                            ),
                          if (schoolYear.isNotEmpty)
                            Text(
                              schoolYear,
                              style: const TextStyle(
                                color: textMuted,
                                fontSize: 12,
                                fontWeight: FontWeight.w500,
                              ),
                            ),
                        ],
                      ),
                    ],
                  ),
                ),
              ],
            ),
            const SizedBox(height: 14),
            Row(
              children: [
                Expanded(
                  child: OutlinedButton.icon(
                    onPressed: () => _viewBulletin(bulletin),
                    icon: const Icon(
                      Icons.visibility_outlined,
                      size: 20,
                    ),
                    label: const Text('Consulter'),
                    style: OutlinedButton.styleFrom(
                      foregroundColor: const Color(0xFF43617D),
                      side: const BorderSide(
                        color: Color(0xFF9CA3AF),
                      ),
                      padding: const EdgeInsets.symmetric(
                        vertical: 13,
                        horizontal: 6,
                      ),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(28),
                      ),
                    ),
                  ),
                ),
                const SizedBox(width: 8),
                Expanded(
                  child: ElevatedButton.icon(
                    onPressed: _isSaving
                        ? null
                        : () => _saveBulletin(bulletin),
                    icon: _isSaving
                        ? const SizedBox(
                            width: 18,
                            height: 18,
                            child: CircularProgressIndicator(
                              strokeWidth: 2,
                              color: primary,
                            ),
                          )
                        : const Icon(
                            Icons.download_outlined,
                            size: 20,
                          ),
                    label: Text(
                      _isSaving ? 'En cours...' : 'Télécharger',
                    ),
                    style: ElevatedButton.styleFrom(
                      backgroundColor: primarySoft,
                      foregroundColor: const Color(0xFF43617D),
                      disabledBackgroundColor: primarySoft,
                      disabledForegroundColor: textMuted,
                      elevation: 0,
                      padding: const EdgeInsets.symmetric(
                        vertical: 13,
                        horizontal: 6,
                      ),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(16),
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}

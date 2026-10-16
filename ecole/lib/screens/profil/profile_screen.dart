import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';

import '../../core/theme/app_theme.dart'; // ✅ import corrigé

class ProfileScreen extends StatelessWidget {
  const ProfileScreen({super.key});

  // ═════════════════════════════════════════════
  // 🎨 COULEURS DE MARQUE (identiques Light/Dark)
  // ═════════════════════════════════════════════
  static const Color primary = AppTheme.primary;
  static const Color primaryDark = AppTheme.primaryDark;

  /// Helper : SVG teinté
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
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      appBar: AppBar(
        elevation: 0,
        scrolledUnderElevation: 0,
        centerTitle: false,
        titleSpacing: 20,
        title: Row(
          children: [
            // Logo dégradé bleu
            Container(
              width: 42,
              height: 42,
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [AppTheme.primary, AppTheme.primaryDark],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),
                borderRadius: BorderRadius.circular(12),
                boxShadow: [
                  BoxShadow(
                    color: AppTheme.primary.withOpacity(0.3),
                    blurRadius: 10,
                    offset: const Offset(0, 4),
                  ),
                ],
              ),
              padding: const EdgeInsets.all(10),
              child: SvgPicture.asset(
                'assets/icons/user.svg',
                colorFilter: const ColorFilter.mode(
                  Colors.white,
                  BlendMode.srcIn,
                ),
              ),
            ),

            const SizedBox(width: 12),

            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisSize: MainAxisSize.min,
              children: [
                Text(
                  'Mon profil',
                  style: TextStyle(
                    color: AppTheme.textDark(context),
                    fontSize: 17,
                    fontWeight: FontWeight.bold,
                    letterSpacing: -0.3,
                  ),
                ),
                const SizedBox(height: 2),
                Text(
                  'Gérez vos informations',
                  style: TextStyle(
                    color: AppTheme.textMuted(context),
                    fontSize: 11,
                    fontWeight: FontWeight.w500,
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
      body: SafeArea(
        child: ListView(
          padding: const EdgeInsets.all(20),
          children: [
            _buildProfileHeader(context),
            const SizedBox(height: 28),
            _buildSectionTitle(context, 'Informations personnelles'),
            const SizedBox(height: 12),
            _buildInfoCard(context),
            const SizedBox(height: 24),
            _buildSectionTitle(context, 'Mon compte'),
            const SizedBox(height: 12),
            _buildMenuItem(
              context,
              iconAsset: 'assets/icons/lock.svg',
              title: 'Changer le mot de passe',
              onTap: () {
                ScaffoldMessenger.of(context).showSnackBar(
                  const SnackBar(
                    content: Text(
                      'Cette fonctionnalité sera bientôt disponible.',
                    ),
                  ),
                );
              },
            ),
            const SizedBox(height: 10),
            _buildMenuItem(
              context,
              iconAsset: 'assets/icons/bell.svg',
              title: 'Notifications',
              onTap: () {
                ScaffoldMessenger.of(context).showSnackBar(
                  const SnackBar(
                    content: Text(
                      'Cette fonctionnalité sera bientôt disponible.',
                    ),
                  ),
                );
              },
            ),
            const SizedBox(height: 10),
            _buildMenuItem(
              context,
              iconAsset: 'assets/icons/help.svg',
              title: 'Aide et assistance',
              onTap: () {
                Navigator.pushNamed(context, '/chat');
              },
            ),
            const SizedBox(height: 24),
            _buildLogoutButton(context),
            const SizedBox(height: 20),
            Center(
              child: Text(
                'École Eden • Espace parents',
                style: TextStyle(
                  color: AppTheme.textMuted(context),
                  fontSize: 12,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildProfileHeader(BuildContext context) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: AppTheme.cardColor(context),
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: AppTheme.border(context)),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        children: [
          // Avatar dégradé bleu avec initiales
          Container(
            width: 88,
            height: 88,
            decoration: BoxDecoration(
              gradient: const LinearGradient(
                colors: [AppTheme.primary, AppTheme.primaryDark],
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
              ),
              shape: BoxShape.circle,
              border: Border.all(
                color: AppTheme.cardColor(context),
                width: 4,
              ),
              boxShadow: [
                BoxShadow(
                  color: AppTheme.primary.withOpacity(0.4),
                  blurRadius: 16,
                  offset: const Offset(0, 6),
                ),
              ],
            ),
            alignment: Alignment.center,
            child: const Text(
              'NP',
              style: TextStyle(
                color: Colors.white,
                fontSize: 28,
                fontWeight: FontWeight.bold,
                letterSpacing: 0.5,
              ),
            ),
          ),
          const SizedBox(height: 16),
          Text(
            'Nom du parent',
            style: TextStyle(
              color: AppTheme.textDark(context),
              fontSize: 20,
              fontWeight: FontWeight.bold,
              letterSpacing: -0.3,
            ),
          ),
          const SizedBox(height: 6),
          Text(
            'Compte parent',
            style: TextStyle(
              color: AppTheme.textMuted(context),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 14),
          // Badge "Espace parents" (vert conservé)
          Container(
            padding: const EdgeInsets.symmetric(
              horizontal: 12,
              vertical: 6,
            ),
            decoration: BoxDecoration(
              color: const Color(0xFFDCFCE7),
              borderRadius: BorderRadius.circular(20),
            ),
            child: Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                Container(
                  width: 6,
                  height: 6,
                  decoration: const BoxDecoration(
                    color: Color(0xFF166534),
                    shape: BoxShape.circle,
                  ),
                ),
                const SizedBox(width: 6),
                const Text(
                  'Espace parents',
                  style: TextStyle(
                    color: Color(0xFF166534),
                    fontSize: 12,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSectionTitle(BuildContext context, String title) {
    return Text(
      title,
      style: TextStyle(
        color: AppTheme.textDark(context),
        fontSize: 16,
        fontWeight: FontWeight.bold,
        letterSpacing: -0.2,
      ),
    );
  }

  Widget _buildInfoCard(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: AppTheme.cardColor(context),
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: AppTheme.border(context)),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        children: [
          _InfoRow(
            iconAsset: 'assets/icons/user.svg',
            label: 'Nom complet',
            value: 'À renseigner',
          ),
          Divider(height: 24, color: AppTheme.border(context)),
          _InfoRow(
            iconAsset: 'assets/icons/email.svg',
            label: 'Adresse e-mail',
            value: 'À renseigner',
          ),
          Divider(height: 24, color: AppTheme.border(context)),
          _InfoRow(
            iconAsset: 'assets/icons/phone.svg',
            label: 'Téléphone',
            value: 'À renseigner',
          ),
        ],
      ),
    );
  }

  Widget _buildMenuItem(
    BuildContext context, {
    required String iconAsset,
    required String title,
    required VoidCallback onTap,
  }) {
    return Material(
      color: AppTheme.cardColor(context),
      borderRadius: BorderRadius.circular(14),
      child: InkWell(
        onTap: onTap,
        borderRadius: BorderRadius.circular(14),
        child: Container(
          padding: const EdgeInsets.all(14),
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(14),
            border: Border.all(color: AppTheme.border(context)),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withOpacity(0.02),
                blurRadius: 8,
                offset: const Offset(0, 3),
              ),
            ],
          ),
          child: Row(
            children: [
              // SVG dans un carré bleu clair
              Container(
                width: 40,
                height: 40,
                decoration: BoxDecoration(
                  color: AppTheme.primarySoftColor(context),
                  borderRadius: BorderRadius.circular(10),
                  border: Border.all(
                    color: AppTheme.primary.withOpacity(0.15),
                  ),
                ),
                padding: const EdgeInsets.all(10),
                child: _svg(
                  asset: iconAsset,
                  color: AppTheme.primaryDark,
                  size: 20,
                ),
              ),
              const SizedBox(width: 14),
              Expanded(
                child: Text(
                  title,
                  style: TextStyle(
                    color: AppTheme.textDark(context),
                    fontSize: 14,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ),
              _svg(
                asset: 'assets/icons/chevron_right.svg',
                color: AppTheme.textMuted(context),
                size: 18,
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildLogoutButton(BuildContext context) {
    return Material(
      color: Colors.transparent,
      borderRadius: BorderRadius.circular(14),
      child: InkWell(
        onTap: () {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(
              content: Text(
                'La déconnexion sera connectée à Laravel.',
              ),
            ),
          );
        },
        borderRadius: BorderRadius.circular(14),
        child: Container(
          padding: const EdgeInsets.symmetric(vertical: 15),
          decoration: BoxDecoration(
            color: AppTheme.cardColor(context),
            borderRadius: BorderRadius.circular(14),
            border: Border.all(
              color: Colors.red.shade200,
              width: 1.2,
            ),
          ),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              _svg(
                asset: 'assets/icons/logout.svg',
                color: Colors.red.shade700,
                size: 20,
              ),
              const SizedBox(width: 10),
              Text(
                'Se déconnecter',
                style: TextStyle(
                  color: Colors.red.shade700,
                  fontSize: 14,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

// ═════════════════════════════════════════════════
// 📋 LIGNE D'INFORMATION
// ═════════════════════════════════════════════════

class _InfoRow extends StatelessWidget {
  final String iconAsset;
  final String label;
  final String value;

  const _InfoRow({
    required this.iconAsset,
    required this.label,
    required this.value,
  });

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        // SVG dans un petit carré bleu clair
        Container(
          width: 40,
          height: 40,
          decoration: BoxDecoration(
            color: AppTheme.primarySoftColor(context),
            borderRadius: BorderRadius.circular(10),
            border: Border.all(
              color: AppTheme.primary.withOpacity(0.15),
            ),
          ),
          padding: const EdgeInsets.all(10),
          child: SvgPicture.asset(
            iconAsset,
            colorFilter: const ColorFilter.mode(
              AppTheme.primaryDark,
              BlendMode.srcIn,
            ),
          ),
        ),
        const SizedBox(width: 12),
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                label,
                style: TextStyle(
                  color: AppTheme.textMuted(context),
                  fontSize: 12,
                  fontWeight: FontWeight.w500,
                ),
              ),
              const SizedBox(height: 4),
              Text(
                value,
                style: TextStyle(
                  color: AppTheme.textDark(context),
                  fontSize: 14,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ],
          ),
        ),
      ],
    );
  }
}
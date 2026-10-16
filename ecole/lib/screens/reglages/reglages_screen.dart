import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';

import '../../core/theme/app_theme.dart'; // ✅ import corrigé

class ReglagesScreen extends StatefulWidget {
  const ReglagesScreen({super.key});

  @override
  State<ReglagesScreen> createState() => _ReglagesScreenState();
}

class _ReglagesScreenState extends State<ReglagesScreen> {
  // ═════════════════════════════════════════════
  // 🎨 COULEURS DE MARQUE (identiques Light/Dark)
  // ═════════════════════════════════════════════
  static const Color primary = AppTheme.primary;
  static const Color primaryDark = AppTheme.primaryDark;

  bool notificationsEnabled = true;
  bool bulletinNotifications = true;
  bool announcementNotifications = true;
  bool messageNotifications = true;

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
                'assets/icons/settings.svg',
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
                  'Réglages',
                  style: TextStyle(
                    color: AppTheme.textDark(context),
                    fontSize: 17,
                    fontWeight: FontWeight.bold,
                    letterSpacing: -0.3,
                  ),
                ),
                const SizedBox(height: 2),
                Text(
                  'Préférences et sécurité',
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
            _buildHeader(),
            const SizedBox(height: 28),

            // ═══════════════════════════════════════
            // 🔔 Notifications
            // ═══════════════════════════════════════
            _buildSectionTitle(context, 'Notifications'),
            _buildCard([
              _buildSwitchTile(
                iconAsset: 'assets/icons/bell.svg',
                title: 'Toutes les notifications',
                subtitle: 'Activer ou désactiver les alertes',
                value: notificationsEnabled,
                onChanged: (value) {
                  setState(() {
                    notificationsEnabled = value;
                    if (!value) {
                      bulletinNotifications = false;
                      announcementNotifications = false;
                      messageNotifications = false;
                    }
                  });
                },
              ),
              _buildDivider(context),
              _buildSwitchTile(
                iconAsset: 'assets/icons/document.svg',
                title: 'Bulletins scolaires',
                subtitle: 'Recevoir les alertes de publication',
                value: bulletinNotifications,
                onChanged: notificationsEnabled
                    ? (value) {
                        setState(() {
                          bulletinNotifications = value;
                        });
                      }
                    : null,
              ),
              _buildDivider(context),
              _buildSwitchTile(
                iconAsset: 'assets/icons/megaphone.svg',
                title: 'Annonces de l\u2019école',
                subtitle: 'Être informé des activités et communiqués',
                value: announcementNotifications,
                onChanged: notificationsEnabled
                    ? (value) {
                        setState(() {
                          announcementNotifications = value;
                        });
                      }
                    : null,
              ),
              _buildDivider(context),
              _buildSwitchTile(
                iconAsset: 'assets/icons/chat.svg',
                title: 'Messages',
                subtitle: 'Recevoir les alertes de nouvelles réponses',
                value: messageNotifications,
                onChanged: notificationsEnabled
                    ? (value) {
                        setState(() {
                          messageNotifications = value;
                        });
                      }
                    : null,
              ),
            ]),

            const SizedBox(height: 24),

            // ═══════════════════════════════════════
            // 🌙 Apparence (avec ValueListenableBuilder)
            // ═══════════════════════════════════════
            _buildSectionTitle(context, 'Apparence'),
            _buildCard([
              ValueListenableBuilder<bool>(
                valueListenable: AppTheme.isDarkMode,
                builder: (context, isDark, child) {
                  return _buildSwitchTile(
                    iconAsset: 'assets/icons/moon.svg',
                    title: 'Mode sombre',
                    subtitle: 'Préférer une interface sombre',
                    value: isDark,
                    onChanged: (value) async {
                      await AppTheme.setDarkMode(value);
                    },
                  );
                },
              ),
            ]),

            const SizedBox(height: 24),

            // ═══════════════════════════════════════
            // 🔒 Compte et sécurité
            // ═══════════════════════════════════════
            _buildSectionTitle(context, 'Compte et sécurité'),
            _buildCard([
              _buildActionTile(
                iconAsset: 'assets/icons/lock.svg',
                title: 'Changer le mot de passe',
                subtitle: 'Protéger votre compte',
                onTap: () => _showMessage(
                  'Le changement de mot de passe sera connecté à Laravel.',
                ),
              ),
              _buildDivider(context),
              _buildActionTile(
                iconAsset: 'assets/icons/user.svg',
                title: 'Informations personnelles',
                subtitle: 'Consulter les informations de votre profil',
                onTap: () {
                  Navigator.pushNamed(context, '/profil');
                },
              ),
              _buildDivider(context),
              _buildActionTile(
                iconAsset: 'assets/icons/logout.svg',
                title: 'Se déconnecter',
                subtitle: 'Quitter votre compte École Eden',
                color: Colors.red.shade700,
                onTap: _confirmLogout,
              ),
            ]),

            const SizedBox(height: 24),

            // ═══════════════════════════════════════
            // ℹ️ À propos
            // ═══════════════════════════════════════
            _buildSectionTitle(context, 'À propos'),
            _buildCard([
              _buildActionTile(
                iconAsset: 'assets/icons/info.svg',
                title: 'À propos d\u2019École Eden',
                subtitle: 'Informations sur l\u2019application',
                onTap: () {
                  showAboutDialog(
                    context: context,
                    applicationName: 'École Eden',
                    applicationVersion: '1.0.0',
                    applicationLegalese:
                        'Application de suivi scolaire et de '
                        'communication entre les parents et l\u2019école.',
                  );
                },
              ),
              _buildDivider(context),
              _buildActionTile(
                iconAsset: 'assets/icons/shield.svg',
                title: 'Confidentialité',
                subtitle: 'Protection de vos informations',
                onTap: () => _showMessage(
                  'La politique de confidentialité sera ajoutée.',
                ),
              ),
            ]),

            const SizedBox(height: 24),
            Center(
              child: Text(
                'École Eden · Version 1.0.0',
                style: TextStyle(
                  color: AppTheme.textMuted(context),
                  fontSize: 12,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ),
            const SizedBox(height: 20),
          ],
        ),
      ),
    );
  }

  // ═════════════════════════════════════════════
  // 🎨 HEADER
  // ═════════════════════════════════════════════

  Widget _buildHeader() {
    return Container(
      padding: const EdgeInsets.all(22),
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          colors: [AppTheme.primary, AppTheme.primaryDark],
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
        ),
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: AppTheme.primary.withOpacity(0.3),
            blurRadius: 20,
            offset: const Offset(0, 10),
          ),
        ],
      ),
      child: Row(
        children: [
          Container(
            width: 58,
            height: 58,
            decoration: BoxDecoration(
              color: Colors.white.withOpacity(0.22),
              shape: BoxShape.circle,
              border: Border.all(
                color: Colors.white.withOpacity(0.35),
                width: 1.5,
              ),
            ),
            padding: const EdgeInsets.all(15),
            child: SvgPicture.asset(
              'assets/icons/settings.svg',
              colorFilter: const ColorFilter.mode(
                Colors.white,
                BlendMode.srcIn,
              ),
            ),
          ),

          const SizedBox(width: 16),

          const Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  'Personnalisez votre espace',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 17,
                    fontWeight: FontWeight.bold,
                    letterSpacing: -0.3,
                  ),
                ),
                SizedBox(height: 7),
                Text(
                  'Gérez vos préférences et la sécurité '
                  'de votre compte.',
                  style: TextStyle(
                    color: Colors.white70,
                    fontSize: 13,
                    height: 1.5,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  // ═════════════════════════════════════════════
  // 🏷️ SECTION TITLE
  // ═════════════════════════════════════════════

  Widget _buildSectionTitle(BuildContext context, String title) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: Row(
        children: [
          Container(
            width: 4,
            height: 18,
            decoration: BoxDecoration(
              color: AppTheme.primary,
              borderRadius: BorderRadius.circular(4),
            ),
          ),
          const SizedBox(width: 10),
          Text(
            title,
            style: TextStyle(
              color: AppTheme.textDark(context),
              fontSize: 18,
              fontWeight: FontWeight.bold,
              letterSpacing: -0.3,
            ),
          ),
        ],
      ),
    );
  }

  // ═════════════════════════════════════════════
  // 📦 CARD
  // ═════════════════════════════════════════════

  Widget _buildCard(List<Widget> children) {
    return Container(
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
      child: Column(children: children),
    );
  }

  Widget _buildDivider(BuildContext context) {
    return Divider(
      height: 1,
      thickness: 1,
      indent: 66,
      color: AppTheme.border(context),
    );
  }

  // ═════════════════════════════════════════════
  // 🔀 SWITCH TILE
  // ═════════════════════════════════════════════

  Widget _buildSwitchTile({
    required String iconAsset,
    required String title,
    required String subtitle,
    required bool value,
    required ValueChanged<bool>? onChanged,
  }) {
    final active = onChanged != null;

    return SwitchListTile(
      contentPadding: const EdgeInsets.symmetric(
        horizontal: 16,
        vertical: 4,
      ),
      secondary: Container(
        width: 40,
        height: 40,
        decoration: BoxDecoration(
          color: active
              ? AppTheme.primarySoftColor(context)
              : (AppTheme.isDark(context)
                  ? const Color(0xFF2A2A2A)
                  : const Color(0xFFF3F4F6)),
          borderRadius: BorderRadius.circular(10),
          border: active
              ? Border.all(
                  color: AppTheme.primary.withOpacity(0.15),
                )
              : null,
        ),
        padding: const EdgeInsets.all(10),
        child: _svg(
          asset: iconAsset,
          color: active
              ? AppTheme.primaryDark
              : AppTheme.textMuted(context),
          size: 20,
        ),
      ),
      title: Text(
        title,
        style: TextStyle(
          color: active
              ? AppTheme.textDark(context)
              : AppTheme.textMuted(context),
          fontSize: 14,
          fontWeight: FontWeight.w600,
        ),
      ),
      subtitle: Text(
        subtitle,
        style: TextStyle(
          color: AppTheme.textMuted(context),
          fontSize: 12,
          height: 1.4,
          fontWeight: FontWeight.w500,
        ),
      ),
      value: value,
      activeTrackColor: AppTheme.primary,
      onChanged: onChanged,
    );
  }

  // ═════════════════════════════════════════════
  // ▶️ ACTION TILE
  // ═════════════════════════════════════════════

  Widget _buildActionTile({
    required String iconAsset,
    required String title,
    required String subtitle,
    required VoidCallback onTap,
    Color? color,
  }) {
    final itemColor = color ?? AppTheme.primaryDark;
    final isDestructive = color != null;

    return ListTile(
      contentPadding: const EdgeInsets.symmetric(
        horizontal: 16,
        vertical: 6,
      ),
      leading: Container(
        width: 40,
        height: 40,
        decoration: BoxDecoration(
          color: isDestructive
              ? color.withOpacity(0.1)
              : AppTheme.primarySoftColor(context),
          borderRadius: BorderRadius.circular(10),
          border: isDestructive
              ? null
              : Border.all(
                  color: AppTheme.primary.withOpacity(0.15),
                ),
        ),
        padding: const EdgeInsets.all(10),
        child: _svg(
          asset: iconAsset,
          color: itemColor,
          size: 20,
        ),
      ),
      title: Text(
        title,
        style: TextStyle(
          color: color ?? AppTheme.textDark(context),
          fontSize: 14,
          fontWeight: FontWeight.w600,
        ),
      ),
      subtitle: Text(
        subtitle,
        style: TextStyle(
          color: AppTheme.textMuted(context),
          fontSize: 12,
          fontWeight: FontWeight.w500,
        ),
      ),
      trailing: _svg(
        asset: 'assets/icons/chevron_right.svg',
        color: AppTheme.textMuted(context),
        size: 18,
      ),
      onTap: onTap,
    );
  }

  // ═════════════════════════════════════════════
  // 💬 MESSAGES
  // ═════════════════════════════════════════════

  void _showMessage(String message) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(content: Text(message)),
    );
  }

  // ═════════════════════════════════════════════
  // 🚪 CONFIRM LOGOUT
  // ═════════════════════════════════════════════

  void _confirmLogout() {
    showDialog<void>(
      context: context,
      builder: (dialogContext) => AlertDialog(
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(20),
        ),
        title: const Text('Se déconnecter ?'),
        content: const Text(
          'Voulez-vous vraiment quitter votre compte ?',
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(dialogContext),
            child: const Text('Annuler'),
          ),
          TextButton(
            onPressed: () {
              Navigator.pop(dialogContext);
              _showMessage(
                'La déconnexion sera connectée à Laravel.',
              );
            },
            child: const Text(
              'Se déconnecter',
              style: TextStyle(color: Colors.red),
            ),
          ),
        ],
      ),
    );
  }
}
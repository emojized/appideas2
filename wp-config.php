<?php
/**
 * In dieser Datei werden die Grundeinstellungen für WordPress vorgenommen.
 *
 * Zu diesen Einstellungen gehören: MySQL-Zugangsdaten, Tabellenpräfix,
 * Secret-Keys, Sprache und ABSPATH. Mehr Informationen zur wp-config.php gibt es
 * auf der {@link http://codex.wordpress.org/Editing_wp-config.php wp-config.php editieren}
 * Seite im Codex. Die Informationen für die MySQL-Datenbank bekommst du von deinem Webhoster.
 *
 * Diese Datei wird von der wp-config.php-Erzeugungsroutine verwendet. Sie wird ausgeführt,
 * wenn noch keine wp-config.php (aber eine wp-config-sample.php) vorhanden ist,
 * und die Installationsroutine (/wp-admin/install.php) aufgerufen wird.
 * Man kann aber auch direkt in dieser Datei alle Eingaben vornehmen und sie von
 * wp-config-sample.php in wp-config.php umbenennen und die Installation starten.
 *
 * @package WordPress
 */

/**  MySQL Einstellungen - diese Angaben bekommst du von deinem Webhoster. */
/**  Ersetze database_name_here mit dem Namen der Datenbank, die du verwenden möchtest. */
define( 'DB_NAME', 'classicpress' );

/** Ersetze username_here mit deinem MySQL-Datenbank-Benutzernamen */
define( 'DB_USER', 'root' );

/** Ersetze password_here mit deinem MySQL-Passwort */
define( 'DB_PASSWORD', '' );

/** Ersetze localhost mit der MySQL-Serveradresse */
define( 'DB_HOST', 'localhost' );

/** Der Datenbankzeichensatz der beim Erstellen der Datenbanktabellen verwendet werden soll */
define( 'DB_CHARSET', 'utf8mb4' );

/** Der collate type sollte nicht geändert werden */
define('DB_COLLATE', '');

/**#@+
 * Sicherheitsschlüssel
 *
 * Ändere jeden KEY in eine beliebige, möglichst einzigartige Phrase.
 * Auf der Seite {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * kannst du dir alle KEYS generieren lassen.
 * Bitte trage für jeden KEY eine eigene Phrase ein. Du kannst die Schlüssel jederzeit wieder ändern,
 * alle angemeldeten Benutzer müssen sich danach erneut anmelden.
 *
 * @seit 2.6.0
 */
define( 'AUTH_KEY',         'dJ@Gl_rE2A[ebupG7&N`Az`f*t2l1 t7-TNqD[qxg?Mn8&q{+WW*g_jagLZh4VrW' );
define( 'SECURE_AUTH_KEY',  'RInZY7X;J*+lz?1.ozTO4J##%7V-y5$8Jy,B@Q6GON2__7}uWcEw(T1Uw?Ew  Z:' );
define( 'LOGGED_IN_KEY',    '`<A?%B_6%?]cjL<K;bQ5maFU~26v_1gZ/Wza5wGt~p%tGbwdhEX.jGrrpi([:4oo' );
define( 'NONCE_KEY',        'AG`bHa9EExc36T~U52oeDR<%&BwzKjsurj*.(5-HHSrPY{xm$ %D;0}p~&~b+po*' );
define( 'AUTH_SALT',        'VqRZ=}UD8`mc+mux[A/}we`cZXhBOK}&8KIz;3Ivsq F#(^N(ca JUM99ZPg@.]!' );
define( 'SECURE_AUTH_SALT', 'hx+T7}O3<58UvG:C2GyA!p&jL4n.0[,rKLI43i)4tT3]zUZUunhr8.,)_{Y`sDHR' );
define( 'LOGGED_IN_SALT',   '~b*`{`r=}j=kSM.pG8r7gxN.=:fgG.fG)*=tp4$jn6hi*{W%Mn#T.8jPEkoE/]cB' );
define( 'NONCE_SALT',       'R=D0}P*ok;BUS#YH^}qTUpqJ~l1`w1MY@<L, $lRVH!aG~3K#9|h[Bjoc]+NH,-&' );

/**#@-*/

/**
 * WordPress Datenbanktabellen-Präfix
 *
 *  Wenn du verschiedene Präfixe benutzt, kannst du innerhalb einer Datenbank
 *  verschiedene WordPress-Installationen betreiben. Nur Zahlen, Buchstaben und Unterstriche bitte!
 */
$table_prefix = 'cp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

Proftp installieren
 aptitude install proftpd proftpd-mod-mysql

Die Dateien "proftpd.conf" und "sql.conf" ins Verzeichnis "/etc/proftpd/" kopieren (�berschreiben)

FTP User auf Konsole anlegen:
 useradd -u 2001 -s /bin/false -d /bin/null -g ftpgroup ftpuser

Danach dem User das Verzeichnis �bergeben:
 chown -R ftpuser:ftpgroup Verzeichnis
 chown -R ftpuser:ftpgroup Verzeichnis/-R

FTP Server neu starten
 /etc/init.d/proftpd restart

Eine MySql Datenbank anlegen und die Datei "proftpd.sql" impoertieren

Die Config Datei im Verzeichnis /assets/config/ wie folgt erg�nzen und anpassen
 [SMT-FTP]
 db_host = localhost
 db_user = username
 db_pass = "password"
 db_base = database
 db_port = 3306
 db_charset=utf8

Die drei Ordner "controller", "library" und "template" in die Hauptstruktur kopieren

Fertig :-)

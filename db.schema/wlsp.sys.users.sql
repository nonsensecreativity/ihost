#
#  Create USER for network-visit recording
#
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.actvst TO 'actrec'@'127.0.0.1' identified by 'actrecatussp';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.actvrf TO 'actrec'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.actvst TO 'wlcap'@'127.0.0.1' identified by 'wlcapatussp';

FLUSH PRIVILEGES;

#
#  Create USER for Registration & Authentication
#
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.authclient TO 'auth'@'127.0.0.1'identified by 'authatussp';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.authmac TO 'auth'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.authsms TO 'auth'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.authblkmac TO 'auth'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.authmacip TO 'auth'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.authnlist TO 'auth'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.wlsta TO 'auth'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.useraccounts TO 'auth'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.usermacs TO 'auth'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.useractive TO 'auth'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.smspool TO 'auth'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.smsrcv TO 'auth'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.userpoints TO 'auth'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.userlog TO 'auth'@'127.0.0.1';

FLUSH PRIVILEGES;

#
#  Create USER for Wireless packet sniffer
#
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.wlact TO 'wlcap'@'127.0.0.1' identified by 'wlcapatussp';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.wlpkt TO 'wlcap'@'127.0.0.1';
GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.wlsta TO 'wlcap'@'127.0.0.1';

FLUSH PRIVILEGES;

GRANT SELECT ON wlsp.viewaction TO 'viewer'@'localhost'identified by 'wlviewer';
GRANT SELECT ON wlsp.viewstation TO 'viewer'@'localhost';

FLUSH PRIVILEGES;

GRANT SELECT, INSERT, UPDATE, DELETE ON wlsp.pushrurl TO 'proxy'@'127.0.0.1' identified by 'proxyatussp';
FLUSH PRIVILEGES;

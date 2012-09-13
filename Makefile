

default: php/wingcgcalc.pot translations/pt_BR/LC_MESSAGES/wingcgcalc.po translations/pt_BR/LC_MESSAGES/wingcgcalc.mo

php/wingcgcalc.pot:    php/index.php
	xgettext -j -o $@ $^

translations/pt_BR/LC_MESSAGES/wingcgcalc.po:   php/wingcgcalc.pot php/index.php
	msgmerge -U translations/pt_BR/LC_MESSAGES/wingcgcalc.po php/wingcgcalc.pot

translations/pt_BR/LC_MESSAGES/wingcgcalc.mo:   translations/pt_BR/LC_MESSAGES/wingcgcalc.po php/wingcgcalc.pot php/index.php
	msgfmt -o translations/pt_BR/LC_MESSAGES/wingcgcalc.mo translations/pt_BR/LC_MESSAGES/wingcgcalc.po




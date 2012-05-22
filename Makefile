

default: en_US/wingcgcalc.pot translations/pt_BR/LC_MESSAGES/wingcgcalc.po translations/pt_BR/LC_MESSAGES/wingcgcalc.mo

en_US/wingcgcalc.pot:    en_US/index.php
	xgettext -j -o $@ $^

translations/pt_BR/LC_MESSAGES/wingcgcalc.po:   en_US/wingcgcalc.pot en_US/index.php
	msgmerge -U translations/pt_BR/LC_MESSAGES/wingcgcalc.po en_US/wingcgcalc.pot

translations/pt_BR/LC_MESSAGES/wingcgcalc.mo:   translations/pt_BR/LC_MESSAGES/wingcgcalc.po en_US/wingcgcalc.pot en_US/index.php
	msgfmt -o translations/pt_BR/LC_MESSAGES/wingcgcalc.mo translations/pt_BR/LC_MESSAGES/wingcgcalc.po




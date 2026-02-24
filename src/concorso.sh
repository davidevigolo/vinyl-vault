#!/bin/bash
#dvigolo
exec		 mysql -h localhost                            -P3306 -u ${LOGNAME} -D ${LOGNAME} --local-infile=1 --password=$( cat $HOME/	pwd_db_caa.txt )

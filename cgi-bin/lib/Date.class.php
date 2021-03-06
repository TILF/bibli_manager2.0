<?php

class Date{
        private static $month = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
        private static $monthLite = array("","Jan","Fév","Mar","Avr","Mai","Jun","Jul","Aoû","Sep","Oct","Nov","Déc");

        public static function getStringDate($date,$lite = true)
        {
            if($lite)
            {
                return self::$monthLite[(int) \substr($date,4,2)] . ' ' . substr($date,0,4);
            }
            return self::$month[(int) \substr($date,4,2)] . ' ' . substr($date,0,4);
        }

        public static function getDate($timeStamp = null)
        {
            if ($timeStamp)
            {
                return date('d/m/Y', $timeStamp);
            }

            return date('d/m/Y');
        }

        public static function getDbDate($timeStamp = null)
        {
            if ($timeStamp)
            {
                return date('Ymd', $timeStamp);
            }

            return date('Ymd');
        }

        public static function getDbHour($timeStamp = null)
        {
            if ($timeStamp)
            {
                return date('His', $timeStamp);
            }

            return date('His');
        }

        public static function getFirstDayOfWeek()
        {
            return self::getDbDate(mktime(2, 0, 0, date('m'), date('d') - date('w') + 1, date('Y')));
        }

        public static function getDiffrence($d1, $d2){
            $diff = abs(strtotime($d2) - strtotime($d1));

            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

            return $diff === 0 ?  'Aujourd\'hui' : ($years != 0 ? $years . ' Ans ' : '')  .  ($months != 0 ? $months . ' Mois ' : '') . $days .  ' Jours';
        }

        public static function dbDateToString($date)
        {
            if (!$date)
            {
                return '';
            }
            $dateFormated = '';
            if(strlen($date) == 8)
            {
                $dateFormated = substr($date, 6, 2) . '/' . substr($date, 4, 2) . '/' . substr($date, 0, 4);
            }
            elseif(strlen($date) == 6)
            {
                $dateFormated = substr($date, 4, 2) . '/' . substr($date, 0, 4);
            }
            return $dateFormated;
        }

        public static function dbDateToStringLite($date)
        {
            if (!$date)
            {
                return '';
            }
            $dateFormated = '';
            if(strlen($date) == 8)
            {
                $dateFormated = substr($date, 6, 2) . '/' . substr($date, 4, 2) . '/' . substr($date, 2, 4);
            }
            elseif(strlen($date) == 6)
            {
                $dateFormated = substr($date, 4, 2) . '/' . substr($date, 0, 4);
            }
            return $dateFormated;
        }

        public static function dbDateToUnixtime($date)
        {
            if (!$date)
            {
                return 0;
            }

            return \mktime(0, 0, 0, substr($date, 4, 2), substr($date, 6, 2), substr($date, 2, 2));
        }

        public static function stringToDbDate($date)
        {
            if (!$date)
            {
                return date('Ymd');
            }

            $date = explode('/', $date);
            return $date[2] . $date[1] . $date[0];
        }

        public static function getLeastOneMonth($date)
        {
            if (strlen($date) > 6)
            {
                $date = substr($date, 0, 6);
            }

            if (strlen($date) != 6)
            {
                return '';
            }

            if(substr($date, 4, 2)== '01')
            {
                return $date- 89;
            }
            else
            {
                return $date - 1;
            }
        }
                
        public static function format2LengthDate($date){
            return strlen($date) === 2 ? '19'.$date : $date;
        }
    }
?>
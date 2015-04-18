<?php
namespace Fr;
/**
.---------------------------------------------------------------------------.
| The Francium Project                                                      |
| ------------------------------------------------------------------------- |
| This software "Translator" is a part of the Francium (Fr) project.        |
| http://subinsb.com/the-francium-project                                   |
| ------------------------------------------------------------------------- |
|     Author: Subin Siby                                                    |
| Copyright (c) 2014 - 2015, Subin Siby. All Rights Reserved.               |
| ------------------------------------------------------------------------- |
|   License: Distributed under the General Public License (GPL)             |
|            http://www.gnu.org/licenses/gpl-3.0.html                       |
| This program is distributed in the hope that it will be useful - WITHOUT  |
| ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     |
| FITNESS FOR A PARTICULAR PURPOSE.                                         |
'---------------------------------------------------------------------------'
*/
/**
.--------------------------------------------------------------------------.
|  Software: Translator                                                    |
|  Version: 0.1  (2015 April 18)                                           |
|  Contact: http://github.com/subins2000/francium-translator               |
|  Documentation: https://subinsb.com/Project-Name                         |
|  Support: http://subinsb.com/ask/Project-Name                            |
'--------------------------------------------------------------------------'
*/

ini_set("display_errors", "on");

class Translator {
  /**
   * ------------
   * BEGIN CONFIG
   * ------------
   * Edit the configuraion
   */
  
  public static $default_config = array(
    /**
     * Information about who uses logSys
     */
    "info" => array(
      "company" => "My Site",
      "email" => "mail@subinsb.com"
    ),
    
    /**
     * Short Codes of languages
     */
    "languages" => array(
      "Detect language" => "auto",
      "Afrikaans" => "af",
      "Albanian" => "sq",
      "Arabic" => "ar",
      "Armenian" => "hy",
      "Azerbaijani" => "az",
      "Basque" => "eu",
      "Belarusian" => "be",
      "Bengali" => "bn",
      "Bosnian" => "bs",
      "Bulgarian" => "bg",
      "Catalan" => "ca",
      "Cebuano" => "ceb",
      "Chichewa" => "ny",
      "Chinese" => "zh-CN",
      "Croatian" => "hr",
      "Czech" => "cs",
      "Danish" => "da",
      "Dutch" => "nl",
      "English" => "en",
      "Esperanto" => "eo",
      "Estonian" => "et",
      "Filipino" => "tl",
      "Finnish" => "fi",
      "French" => "fr",
      "Galician" => "gl",
      "Georgian" => "ka",
      "German" => "de",
      "Greek" => "el",
      "Gujarati" => "gu",
      "Haitian Creole" => "ht",
      "Hausa" => "ha",
      "Hebrew" => "iw",
      "Hindi" => "hi",
      "Hmong" => "hmn",
      "Hungarian" => "hu",
      "Icelandic" => "is",
      "Igbo" => "ig",
      "Indonesian" => "id",
      "Irish" => "ga",
      "Italian" => "it",
      "Japanese" => "ja",
      "Javanese" => "jw",
      "Kannada" => "kn",
      "Kazakh" => "kk",
      "Khmer" => "km",
      "Korean" => "ko",
      "Lao" => "lo",
      "Latin" => "la",
      "Latvian" => "lv",
      "Lithuanian" => "lt",
      "Macedonian" => "mk",
      "Malagasy" => "mg",
      "Malay" => "ms",
      "Malayalam" => "ml",
      "Maltese" => "mt",
      "Maori" => "mi",
      "Marathi" => "mr",
      "Mongolian" => "mn",
      "Myanmar (Burmese)" => "my",
      "Nepali" => "ne",
      "Norwegian" => "no",
      "Persian" => "fa",
      "Polish" => "pl",
      "Portuguese" => "pt",
      "Punjabi" => "pa",
      "Romanian" => "ro",
      "Russian" => "ru",
      "Serbian" => "sr",
      "Sesotho" => "st",
      "Sinhala" => "si",
      "Slovak" => "sk",
      "Slovenian" => "sl",
      "Somali" => "so",
      "Spanish" => "es",
      "Sundanese" => "su",
      "Swahili" => "sw",
      "Swedish" => "sv",
      "Tajik" => "tg",
      "Tamil" => "ta",
      "Telugu" => "te",
      "Thai" => "th",
      "Turkish" => "tr",
      "Ukrainian" => "uk",
      "Urdu" => "ur",
      "Uzbek" => "uz",
      "Vietnamese" => "vi",
      "Welsh" => "cy",
      "Yiddish" => "yi",
      "Yoruba" => "yo",
      "Zulu" => "zu",
    ),
    
    /**
     * Any default languages
     */
    "default" => array(
      "from" => "en",
      "to" => "ml"
    )
  );
  
  /* ------------
   * END Config.
   * ------------
   * No more editing after this line.
   */
  
  public static $config = array();
  private static $constructed = false;
  
  /**
   * Merge user config and default config
   */
  public static function config(){
    self::$config = array_merge(self::$default_config, self::$config);
  }
  
  /**
   * Log something in the Francium.log file.
   * To enable logging, make a file called "Francium.log" in the directory
   * where "class.logsys.php" file is situated
   */
  public static function log($msg = ""){
    $log_file = __DIR__ . "/Francium.log";
    if(file_exists($log_file)){
      if($msg != ""){
        $message = "[" . date("Y-m-d H:i:s") . "] $msg";
        $fh = fopen($log_file, 'a');
        fwrite($fh, $message . "\n");
        fclose($fh);
      }
    }
  }
  
  public static function construct(){
    self::config();
  }
  
  /**
   * Translate a word
   */
  public static function translate($word, $to = "", $from = "auto"){
    /**
     * If `to` language is notspecified, use the default
     * one mentioned in `config`->`default`
     */
    if($to == ""){
      $to = self::$config['default']['to'];
    }
    
    $url = "https://translate.google.com/translate_a/single?client=webapp&sl={$from}&tl={$to}&hl={$from}&dt=bd&dt=ex&dt=ld&dt=md&dt=qc&dt=rw&dt=rm&dt=ss&dt=t&dt=at&ie=UTF-8&oe=UTF-8&prev=btn&rom=1&ssel=3&tsel=4&tk=520078|504525&q=" . urlencode($word);
    
    $response = self::url_get_contents($url);
    if($response !== false){
      preg_match('/\[\[\[\"(.*?)\"/', $response, $matches);
      $translated = $matches[1];
    
      if($translated == $word){
        // No Translation available
        return null;
      }else{
        return $translated;
      }
    }else{
      return false;
    }
  }
  
  public static function url_get_contents($url) {
    if (!function_exists('curl_init')){ 
      self::log('CURL is not installed!');
    }else{
      $ch = curl_init();
      
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $output = curl_exec($ch);
      
      if(curl_errno($ch)){
        self::log('cURL Error : ' . curl_error($ch));
        $output = false;
      }
      curl_close($ch);
      
      return $output;
    }
  }
}
\Fr\Translator::construct();

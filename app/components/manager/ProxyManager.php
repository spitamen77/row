<?php
/**
 * Created by PhpStorm.
 * User: RashidovN
 * Date: 22.07.2015
 * Time: 19:34
 */

namespace app\components\manager;


class ProxyManager
{
    public function run()
    {
        sleep(1);

        $url = $_REQUEST['url']; //URL to grab (again, see NOTE on security above)
        if (empty($url)) {
            $url = "";
        } //make sure we always get some data (default to your user ID, you did not tell me if it is to be used in a multi-user application or not, but this should scale)

        /**
         * getAddress
         * @get the full url of the current page (protocol + host + request URI including parameters)
         * @return string
         */
        function getAddress()
        {
            return $_SERVER['SERVER_PROTOCOL'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            /*** return the full address ***/
        }

//parse the passed in URL using parameterized query object (could add validation here, see: http://www.scriptol.com/how-to/parsing-url.php )
        $arr = parse_url(getAddress()); //use PHP convenience function for full address
        $parameters = $arr["query"];
        parse_str($parameters, $param);

        $format = $param['f']; //examples:   &f=xml | &f=json | &f=html  (for more MIME-Types, see: http://en.wikipedia.org/wiki/Mime_type)
        $encoding = $param['e']; //examples:   &e=utf-8 | &e=iso-8859-1 | &e=Shift-JIS  (for more Character Encodings, see: http://en.wikipedia.org/wiki/Character_encoding)
        $e = (!empty($encoding)) ? $encoding : "utf-8"; //might want to limit allowed charset/encoding types

        header('Cache-Control: no-cache, must-revalidate'); //force fresh request
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
// Set your return content type, based on the expected response type...
        switch ($format) {
            case "xml":
            case "xsl":
            case "kml":
                header("Content-type: application/xml; charset={$e}");
                break;
            case "geojson":
            case "json":
            case "rdfjson":
            case "rdf/json":
            case "rdf+json":
            case "jron":
                header("Content-type: application/json; charset={$e}");
                break;
            case "georss":
            case "atom":
                header("Content-type: application/atom+xml; charset={$e}");
                break;
            case "rss":
                header("Content-type: text/xml; charset={$e}");
                break;
            case "rss2":
            case "rss2.0":
                header("Content-type: text/xml; charset={$e}");
                break;
            case "rss1":
            case "rss1.0":
                header("Content-type: text/xml; charset={$e}");
                break;
            case "rss0.92":
            case "rss0.91":
            case "rss0.90":
            case "feed":
            case "rdf":
                header("Content-type: text/xml; charset={$e}");
                break;
            case "owl":
            case "rdf+xml":
            case "rdfxml":
                header("Content-type: application/rdf+xml; charset={$e}");
                break;
            case "swf":
            case "flash":
            case "flv":
                header("Content-type: application/x-shockwave-flash");
                break;
            case "image":
                header("Content-type: image/png");
                break;
            case "svg":
                header("Content-type: image/svg+xml");
                break;
            case "audio":
            case "ogg":
                header("Content-type: audio/ogg");
                break;
            case "mp3":
                header("Content-type: audio/mpeg");
                break;
            case "video":
            case "webm":
                header("Content-type: video/webm");
                break;
            case "mp4":
                header("Content-type: video/mp4");
                break;
            case "xhtml":
                header("Content-type: application/xhtml+xml; charset={$e}");
                break;
            case "xslt":
            case "html":
            case "html5":
                header("Content-type: text/html; charset={$e}");
                break;
            default:
                header("Content-type: text/plain; charset={$e}"); //could be any other plaintext format (including: CSV, TSV, conf, ini, rtf, txt, dat, n3, turtle, JSONp etc...)
                break;
        }


        try {
            // Get remote content/data  (NOTE: your hosting provider may not allow fopen, if not you can request they allow for your VPS...if still not, we can use file_get_contents  or CURL lib instead)
            $handle = fopen($url, "r");

            // some content/data was received, then read & return
            if ($handle) {
                while (!feof($handle)) {
                    $buffer = fgets($handle, 4096);
                    echo $buffer;
                }
                fclose($handle);
            }
        } catch (\Exception $e) {
            return file_get_contents($url);
        }
    }
}
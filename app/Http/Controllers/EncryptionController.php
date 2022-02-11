<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EncryptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
    }

    // function encryptionMethod(){
    //     return 'aes-256-cbc';
    // }

    // function authorizeKey($key)
    // {
    //     return hash('sha256', $key);
    // }

    // function iv(){
    //     return substr(hash('sha256', "ng"), 0, 16);
    // }



    function convertMeToBinary($me)
    {
        $fileToConvert = (string)$me;
        $l = strlen($fileToConvert);
        $result = "";
        $index = 0;
        while ($l--) {
            $result = str_pad(decbin(ord($fileToConvert[$l])), 8, '0',  STR_PAD_LEFT) . $result;
            // echo "\t\t=  $result <br>";
        }
        return $result;
    }

    function embedMessageIntoImage($message, $image)
    {

        // move_uploaded_file($_FILES["image"]["tmp_name"], $image);
        $split = explode('/', $image);
        // return $image;
        $images = $split[1];
        // echo "Uploaded";$algo."YOBEGAIL".
        $msg = $message;

        $src = $image;
        //Start image
        // return $src;

        $msg .= 'vb';
        //EOF sign, decided to use the pipe symbol to show our decrypter the end of the message
        $msgBin = $this->convertMeToBinary($msg);
        //Convert our message to binary
        $msgLength = strlen($msgBin);
        //Get message length
        // return ;
        $type = pathinfo(public_path($image), PATHINFO_EXTENSION);
        // return $type;
        // return $msgBin;
        if ($type == 'jpg' || $type == 'jpeg') {
            $img = imagecreatefromjpeg($src);
        } else {
            $img = imagecreatefrompng($src);
        }
        //returns an image identifier
        list($width, $height, $type, $attr) = getimagesize($src);
        //get image size

        if ($msgLength > ($width * $height)) {
            //The image has more bits than there are pixels in our image
            $mError = 'Message too long. This is not supported as of now.';
            die();
        }

        $pixelX = 0;
        //Coordinates X of our pixel that we want to edit
        $pixelY = 0;
        //Coordinates Y of our pixel that we want to edit

        for ($x = 0; $x < $msgLength; $x++) {
            //Encrypt message bit by bit (literally)

            if ($pixelX === $width + 1) {
                //If this is true, we've reached the end of the row of pixels, start on next row
                $pixelY++;
                $pixelX = 0;
            }

            if ($pixelY === $height && $pixelX === $width) {
                //Check if we reached the end of our file
                $mError = 'Max Reached';
                die();
            }

            $rgb = imagecolorat($img, $pixelX, $pixelY);
            //Color of the pixel at the x and y positions
            $r = ($rgb >> 16) & 0xFF;
            //returns red value for example int(119)
            $g = ($rgb >> 8) & 0xFF;
            //^^ but green
            $b = $rgb & 0xFF;
            //^^ but blue

            $newR = $r;
            //we dont change the red or green color, only the lsb of blue
            $newG = $g;
            //^
            $newB = $this->convertMeToBinary($b);
            //Convert our blue to binary
            $newB[strlen($newB) - 1] = $msgBin[$x];
            //Change least significant bit with the bit from out message
            $newB = $this->toString($newB);
            //Convert our blue back to an integer value (even though its called tostring its actually toHex)

            $new_color = imagecolorallocate($img, $newR, $newG, $newB);
            //swap pixel with new pixel that has its blue lsb changed (looks the same)
            imagesetpixel($img, $pixelX, $pixelY, $new_color);
            //Set the color at the x and y positions
            $pixelX++;
            //next pixel (horizontally)

        }
        //Random digit for our filename
        $encrypt = "stegoImage/";
        if (!is_dir($encrypt)) {
            mkdir($encrypt);
        }
        // return $encrypt;
        $stego = imagepng($img, $encrypt . $images);
        return $encrypt . $images;

        imagedestroy($img); //get rid of it
    }





    function toString($str)
    {
        $text_array = explode("\r\n", chunk_split($str, 8));
        $newstring = '';
        for ($n = 0; $n < count($text_array) - 1; $n++) {
            $newstring .= chr(base_convert($text_array[$n], 2, 10));
            // echo "$n \t =  \t $newstring\t = \t " . convertMeToBinary($newstring) ."\t  =  \t". baseConvert(convertMeToBinary($newstring), 2, 36) ." <br>";
        }
        return $newstring;
    }




    public function steganogagraphy(Request $request)
    {
        $request->validate([
            'encrypedmessage' => 'required|string',
            'coverimage' => 'required|image|mimes:png,jpg'
        ]);
        // return $request;
        if ($file = $request->file('coverimage')) {
            $file_name = time() . "." . $file->getClientOriginalExtension();

            $cover =  $file->move('Coverimage', $file_name);
            $embed = $this->embedMessageIntoImage($request->encrypedmessage, $cover);
            if ($embed) {
                return $embed;
                return view('users.staffs.encrypted', compact(['embed', 'algo']));
                return redirect()->back()->with(['success' => 'Message Embed successfully', 'stegoimage', $embed]);
            }
        }
        // return $this->convertMeToBinary($request->encrypedmessage);

    }


    public function decryptStego(Request $request)
    {
        $request->validate([
            // 'dprivate' => 'required|string',
            'stegoimage' => 'required|image|mimes:png,jpg'
        ]);

        // return $request;
        $status = $request->status;
        // return $status;
        $cipherText = $this->steganalysis($request->file('stegoimage'));

        if($status=="check"){
            return json_encode(array('check' => 'The image is stegano image'));
        }elseif($status=="decode"){
            $cipherText = $this->steganalysis($request->file('stegoimage'));
            return json_encode(array('plain'=>$cipherText));
        }elseif ($status=="destroy") {

            if ($file = $request->file('stegoimage')) {

                $cipherText = $this->steganalysis($request->file('stegoimage'));
                  $file_name = time() . "." . $file->getClientOriginalExtension();

                $cover =  $file->move('Coverimage', $file_name);
                // return $cipherText;
                $embed = $this->embedMessageIntoImage($cipherText, $cover);
                if ($embed) {
                    // return $embed;
                    // $destroy =  view('users.staffs.encrypted', compact(['embed']));
                    // return print_r($destroy);
                    return json_encode(array('destroy'=>asset($embed), 'msg'=>'Message Destroyed Successfully, Kindly Download the destroyed image below'));

                    // return redirect()->back()->with(['success' => 'Message destroyed successfully', 'stegoimage', $embed]);
                }
            }
         }



    }


    function steganalysis($image)
    {
        $src = $image;
        // return $src;
        $img = imagecreatefrompng($src);
        //Returns image identifier
        $real_message = '';
        //Empty variable to store our message

        $count = 0;
        //Wil be used to check our last char
        $pixelX = 0;
        //Start pixel x coordinates
        $pixelY = 0;
        //start pixel y coordinates

        list($width, $height, $type, $attr) = getimagesize($src);
        //get image size
        // echo "<br>height = $height<br>";
        for ($x = 0; $x < ($width * $height); $x++) {
            //Loop through pixel by pixel
            if ($pixelX === $width + 1) {
                //If this is true, we've reached the end of the row of pixels, start on next row
                $pixelY++;
                $pixelX = 0;
            }

            if ($pixelY === $height && $pixelX === $width) {
                //Check if we reached the end of our file
                echo ('Max Reached');
                die();
            }

            $rgb = imagecolorat($img, $pixelX, $pixelY);
            //Color of the pixel at the x and y positions
            $r = ($rgb >> 16) & 0xFF;
            //returns red value for example int(119)
            $g = ($rgb >> 8) & 0xFF;
            //^^ but green
            $b = $rgb & 0xFF;
            //^^ but blue
            // echo "<br> X = $pixelX, Y = $pixelY, R = $r, G = $g, B = $b RGB = $rgb<br>";
            $blue = $this->convertMeToBinary($b);
            //Convert our blue to binary
            // echo "Blue = ". $blue."<br>";

            $real_message .= $blue[strlen($blue) - 1];
            //Ad the lsb to our binary result
            // echo "Real message = $real_message<br>";

            $count++;
            //Coun that a digit was added

            if ($count == 8) {
                //Every time we hit 8 new digits, check the value
                if ($this->toString(substr($real_message, -8)) === '|') {
                    // Whats the value of the last 8 digits?
                    // echo ('done<br>');
                    //  Yes we're done now
                    $real_message = $this->toString(substr($real_message, 0, -8));
                   return $real_message;
                    // Show
                    // die;
                }
                $count = 0;
                //Reset counter
            }

            $pixelX++;
            //Change x coordinates to next
        }
        // echo "Message =  $real_message";
        return $real_message;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

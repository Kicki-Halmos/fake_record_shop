<?php 
    
    require_once "/generate_recordsApi.php";

    class App {

        public static function main(){
            $records = self::getRecords();
            if(isset($_GET['genre']) || (isset($_GET['show']) && isset($_GET['genre']))){
                self::getGenre($records);
            }
            elseif(isset($_GET['show'])){
                self::showRandom($records);
            }
            else {
                self::renderData($records);
            }

        }

        public static function getRecords(){
            $records = generateApi();  
            return $records;       
        }

        public static function showRandom($records){
                $amount = intval($_GET['show']);
                $array = array();
                if($amount > 20){
                    $error = array('Show'=>"Show must be between 1 and 20");
                    array_push($array,$error);
                }
                else{
                for($i=0;$i<$amount;$i++){
                    $record = $records[rand(0,19)];
                    array_push($array, $record);
                    }
                }
                self::renderData($array);
            
        }

        public static function getGenre($records){

            //check genre
            $genre = $_GET['genre'];
            $array = array();
            if($genre === "electronic"){
               
                foreach($records as $record){
                    if($record['genre']=== "electronic"){
                        array_push($array, $record);
                    }
                }
            }
            elseif($genre === "indie"){
                
                foreach($records as $record){
                    if($record['genre']=== "indie"){
                        array_push($array, $record);
                    }
                }
            }
            elseif($genre === "rnb"){
               
                foreach($records as $record){
                    if($record['genre']=== "rnb"){
                        array_push($array, $record);
                    }
                }
            }

            elseif($genre === "pop"){
                
                foreach($records as $record){
                    if($record['genre']=== "pop"){
                        array_push($array, $record);
                    }
                }
            }

            //if invalid genre
            else {
                $error['Genre'] = "Genre is not found";
                array_push($array, $error);
            }

            // if genre & show
            if (isset($_GET['show'])) {
                self::getGenreAndShow($array);
            }
            else {
             self::renderData($array);
            }
     }
        
        public static function getGenreAndShow($array){
                $limit_array = array();
                $amount = "";

               // check value of show
               if (intval($_GET['show']) <= 5) {
                $amount = intval($_GET['show']);
               } 

               //value of "show" can't be higher than 5 
               else {
                $error["Show + Genre"]="Value of Show together with Genre must be between 1 and 5"; 
                array_push($limit_array, $error); 
               } 
                
               //if invalid genre
                if(count($array) < $amount) {
                    $error['Genre'] = "Genre is not found";
                    array_push($limit_array, $error);
                    //self::RenderData($limit_array);
                } 

                else {
                    for($i=0; $i<$amount; $i++){
                    $record = $array[rand(0,count($array)-1)];
                    array_push($limit_array, $record);
                    }
                } 
                
           self::renderData($limit_array);
        }

        public static function renderData($records){
            $json = json_encode($records, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); 
           
            echo $json;
        }
    }

?>
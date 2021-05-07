<?php 

    //require_once('generate_recordsApi.php'); --detta kommando funkar bra i localhost/mamp men ej när jag deployar till heroku
      require_once('Record.php');  
    class App {

        public static function main(){
            //hämta records-array
            $records = self::getRecords();

            //kolla om querys finns och anropa lämplig metod 
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

        //hämtar records-array
        public static function getRecords(){
            $records = self::generateApi();  
            return $records;       
        }

        //visar ett randomiserat antal skivor baserat på queryn "show"
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

        //hämtar queryn genre och visar endast de skivor som tillhör den genre som anges
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
        
        //hämtar både query genre och show och hanterar dessa
        public static function getGenreAndShow($array){
                $limit_array = array();
                $amount = "";

               // check value of show
               if (intval($_GET['show']) <= 5) {
                $amount = intval($_GET['show']);
               } 

               //value of show can't be higher than 5 
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

        //renderar skivorna som json-fil
        public static function renderData($records){
            $json = json_encode($records, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); 
           
            echo $json;
        }

        //genererar records-api
        public static function generateAPI(){
            $records = array();
        
            $record = new Record(
                1,
                "Jacques Greene",
                "Dawn Chorus: Limited Edition Purple Vinyl 2LP",
                "LuckyMe proudly present the new album from Jacques Greene ~ Dawn Chorus on limited edition purple vinyl. The record is bold step forward and his most collaborative project to date, featuring additional production and instruments from film composer Brian Reitzell (Lost In Translation), cello by London’s Oliver Coates, additional production from Clams Casino and vocal contributions from ambient artist Julianna Barwick, rapper Cadence Weapon and singers Ebhoni and Rochelle Jordan. If the Canadian artist’s 2017 debut album Feel Infinite was the soundtrack to a dream pregame – amping you up to lose yourself in the club – then Dawn Chorus resides in the post-rave reflective moment. A time of heightened sensuality and latent possibility.",
                "https://picsum.photos/500?random=1",
                "30.99€",
                "electronic"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                2,
                "Burial",
                "Chemz / Dolphinz",
                "‘Chemz’ is hooky, rushy and loved-up - both an unhinged premonition of unleashed post-pandemic joy, and a demonic flashback to past ecstasies in a hardcore style perfected in the UK. ‘Chemz’ is a 12 minute rave monster that has ingested several tracks and incorporated them into its distended body. At the other end of the Burial bi-polar spectrum, ‘Dolphinz’ is a desolate oceanic love letter to our underwater friends.",
                "https://picsum.photos/500?random=2",
                "11.99€",
                "electronic"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                3,
                "DJ Black Low",
                "Uwami",
                "Dark, searching amapiano electronic music from a new producer. Relatively new style of music for listeners outside South Africa. Reflects the feeling of 2020: stark, disruptive, scary. Part of a wave of young producers making vital new music in SA. Sounds like nothing else right now.",
                "https://picsum.photos/500?random=3",
                "23.99€",
                "electronic"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                4,
                "Mount Kimbie",
                "Dawn Chorus: Limited Edition Purple Vinyl 2LP",
                "In 2010, Mount Kimbie released their debut album, Crooks & Lovers, to widespread acclaim. Perfectly capturing the heady atmosphere of the moment, the album melded the wide-eyed mentality of what had become known as ‘Post-Dubstep’ with an open-minded musical sensibility that produced an instant classic. Ten years later, the album is reissued on Hotflush with a bonus disc of the band’s first ever release.",
                "https://picsum.photos/500?random=4",
                "35.99€",
                "electronic"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                5,
                "Telex",
                "This Is Telex: CD",
                "This Is Telex is a brand new compilation collecting 14 tracks from the innovative Belgium trio, covering their career from formation in 1978 up to the final album in 2006. This compilation includes the hit single Moskow Disko as well as their Eurovision Song Contest entry, aptly called Euro-vision.",
                "https://picsum.photos/500?random=5",
                "12.99€",
                "electronic"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                6,
                "Oscar Lang",
                "Chew The Scenery: Signed Poppy Red Vinyl",
                "Chew The Scenery is the debut album from Oscar Lang. Single 'poppy red' coloured vinyl with printed inner, lyric sheet & download card, sleeve signed by Oscar exclusively for recordstore.co.uk.",
                "https://picsum.photos/500?random=6",
                "25.99€",
                "indie"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                7,
                "Japanese Breakfast",
                "Jubilee: Black Vinyl",
                "From the moment she began writing her new album, Japanese Breakfast’s Michelle Zauner knew that she wanted to call it Jubilee. After all, a jubilee is a celebration of the passage of time—a festival to usher in the hope of a new era in brilliant technicolor. Zauner’s first two albums garnered acclaim for the way they grappled with anguish; Psychopomp was written as her mother underwent cancer treatment, while Soft Sounds From Another Planet took the grief she held from her mother‘s death and used it as a conduit to explore the cosmos. Now, at the start of a new decade, Japanese Breakfast is ready to fight for happiness, an all-too-scarce resource in our seemingly crumbling world. ",
                "https://picsum.photos/500?random=7",
                "21.99€",
                "indie"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                8,
                "Peter Murphy",
                "Cascade: Limited Edition Double Scarlet Vinyl",
                "His last solo album for Beggars, Cascade came after a time of change for Peter Murphy. He had dissolved his longtime backing band and moved to Turkey with his family. After a year of soul-searching and re-discovery, the songs flowed. He said “It confirmed my belief that writing – like painting or any art form – comes from a very silent place that’s not dependent on outside stimulus. It was like rediscovering the initial innocence and purity that’s there when you join your first band.” The album was written with Paul Statham and produced by Pascal Gabriel. It also contains guitar work by noted artist Michael Brook.",
                "https://picsum.photos/500?random=8",
                "29.99€",
                "indie"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                9,
                "Rostam",
                "Changephobia: Limited Edition Cassette",
                "Changephobia is the 2nd full-length solo record from Grammy Awardwinning songwriter, producer, and composer Rostam Batmanglij. An adventurous new direction for Rostam, the songs collected on Changephobia are deeply personal, yet universal for anyone who has ever experienced doubt. In addition to being a founding member of the seminal New York Indie Rock Band, Vampire Weekend, Rostam has been described as “one of the great pop and indie-rock producers of his generation.” ",
                "https://picsum.photos/500?random=9",
                "9.99€",
                "indie"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                10,
                "Spang Sisters",
                "Spang Sisters: Soft Lilac Vinyl",
                "RnB-flecked bedroom folk duo Spang Sisters are excited to confirm that their debut full length album will be arriving this spring.
                The Brighton/Bristol duo have a palpable appreciation and knowledge of the music of yesteryear, which manifests itself with poise throughout the band’s output. The Velvet Underground, Motown, Dr.Dre and the Japanese folk band Happy End have all contributed inspiration to a debut record that is unlike any other.",
                "https://picsum.photos/500?random=10",
                "24.99€",
                "indie"
            );
            array_push($records, $record->toArray());
        
           $record = new Record(
                11,
                "Billie Eilish",
                "‘Happier Than Ever’ Vinyl",
                "",
                "https://picsum.photos/500?random=11",
                "42.99€",
                "pop"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                12,
                "NINA",
                "The Beginning",
                "The Queen of Synthwave presents the singles and b-sides that started it all, including NINA's four seminal songs in digital and physical formats plus the addition of instrumentals. NINA's earliest releases introduced to a new generation of fans and adepts. Also included, the iconic Blondie’s 'Heart Of Glass' reimagined as a Synthwave anthem. A crowd favourite at the live shows.",
                "https://picsum.photos/500?random=12",
                "13.99€",
                "pop"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                13,
                "Easy Life",
                "lifes a beach: standard cassette",
                "Standard clear frosted cassette with ‘life’s a beach’ artwork",
                "https://picsum.photos/500?random=13",
                "8.79€",
                "pop"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                14,
                "Moby",
                "Reprise: Exclusive Deluxe 180gm Crystal Clear Vinyl 2LP + Little Idiot Slipmat - Double Vinyl LP",
                "Moby’s latest album Reprise available now in special 2-LP limited edition on top-quality 180g crystal clear vinyl! Double LP in gatefold sleeve, includes Moby’s personal essay on this exciting new project, rich selection of photos by and of the artist and black polyester slipmat with Little Idiot design.",
                "https://picsum.photos/500?random=14",
                "49.99€",
                "pop"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                15,
                "Meduza",
                "Piece Of Your Heart/ Lose Control: Exclusive Picture Disc Vinyl",
                "Limited 10inch Picture-Vinyl in transparent foil sleeve",
                "https://picsum.photos/500?random=15",
                "13.99€",
                "pop"
            );
            array_push($records, $record->toArray());
        
        
            $record = new Record(
                16,
                "Laura Mvula",
                "Pink Noise: Pink Vinyl LP",
                "Laura Mvula’s new album ‘Pink Noise’ is set for release on July 2nd. ‘Pink Noise’ explores a side of Laura previously uncharted. As triumphant as ever, the album is a battle cry and stark reminder of the sheer talent of the critically acclaimed artist. This is Laura in a new found light - still reflecting her distinctive signature sound but showing the progression of an artist who has come into her own.",
                "https://picsum.photos/500?random=16",
                "23.99€",
                "rnb"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                17,
                "McKinley Dixon",
                "For My Mama And Anyone Who Look Like Her: Limited Edition Mango Colour Vinyl",
                "Richmond, Virginia-based artist McKinley Dixon has always used his music as a tool for healing, exploring, and unpacking the Black experience in order to create stories for others like him. For My Mama And Anyone Who Look Like Her, Dixon’s debut album on Spacebomb, is the culmination of a journey where heartbreak and introspection challenged him to adapt new ways of communicating physically and mentally, as well as across time and space. The language accessibility aspect of this project draws right back to communication and connecting,” Dixon explains. “I think about the messaging, and how this can be a way for another Black person, someone who looks like me, to listen to this and process the past. ",
                "https://picsum.photos/500?random=1",
                "25.99€",
                "rnb"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                18,
                "Raleigh Ritchie",
                "Andy: Signed CD",
                "Raleigh Ritchie releases his highly anticipated second album, ANDY. A twelve track project, Andy sees Bristol born and London-hailing Raleigh holding a colossal magnifying glass to himself. Over the production, for the most part, from long-term collaborator Chris Loco but also, the incredibly talented GRADES on “Time In A Tree” and “27 Club”, Raleigh leaves no stone unturned. The album is a creation of heartbreakingly honest songs that seamlessly fuses sweeping soul and mellow R&B with forward-thinking electronica and gutsy orchestral moments. (Raleigh has become well known for working with the sensational Rosie Danvers and Wired Strings.) This is a truly powerful record, a long-awaited return that packs a poignant punch.",
                "https://picsum.photos/500?random=18",
                "12.99€",
                "rnb"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                19,
                "Madlib, Four Tet",
                "Sound Ancestors (Arranged By Kieran Hebden)",
                "Gil Evans to Miles Davis…. Holger Czukay to the ensemble known as Can….Jean Claude Vannier to Serge Gainsbourg on Histoire de Melody Nelson. That’s the only way to explain the specificity of Four Tet and Madlib’s collaboration, in this special album that showcases a two-decade long friendship that has resulted in an album that follows Madlib’s classics like Quasimoto’s The Unseen, Madvillainy and his Pinata and Bandana albums with Freddie Gibbs.",
                "https://picsum.photos/500?random=19",
                "33.99€",
                "rnb"
            );
            array_push($records, $record->toArray());
        
            $record = new Record(
                20,
                "Ocean Wisdom",
                "Stay Sane",
                "Ocean Wisdom reveals he will be releasing his hotly-anticipated third album ’Stay Sane’ on February 19th 2021 on his own label Beyond Measure Records. The album will feature latest single ‘Drilly Rucksack’. Speaking on the album, Ocean said: “This album is called ‘Stay Sane’ and I made it to help myself cope after losses and tribulations. I hope it can help other people to heal and relax.”",
                "https://picsum.photos/500?random=1",
                "15.99€",
                "rnb"
            );
            array_push($records, $record->toArray());
        
              return $records;
        }
    }

?>
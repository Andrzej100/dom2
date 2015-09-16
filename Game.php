<?php

/**
 * Description of Game
 *
 * @author piotr.switala <piotr.switala@powiat.poznan.pl>
 */
class Game extends request {
   
    
    /**
     * Obsługa głównego wątku gry
     */
    public function start() {
        $sesja= new sesja();
        $sesja->sessionstart();
          if(!isset($_POST['submit'])){ 
       echo"Czychcesz sie zarejestrować czy zalogować?";
          echo $this->wybor();
          }
          elseif(isset($_POST['rejestracja'])){
              $ladowanie=new ladowanie();
              echo $ladowanie->formularz("rejestracja");
              if($ladowanie->rejestracja()==true){
                  echo"Rejestracja zakonczona pomyslnie";
                  echo"Czychcesz sie zarejestrować czy zalogować?";
                 echo $this->wybor();
              }
          }
          elseif(isset($_POST['logowanie'])){
              $ladowanie=new ladowanie();
              echo $ladowanie->formularz("logowanie");
              if($ladowanie->login()==true){
                  echo"Logowanie zakonczone pomyslnie";
                 $sesja->sessionset();
               echo $ladowanie->wybierzpostac();
              }
          }
       if($_POST['submit']=="wybierz"){
            $ladowanie=new ladowanie();
            $wybor=$ladowanie->wyborpostaci();
            $postac= new Wiedźmin($wybor);
            echo 'wybrales'+$ladowanie->wyborpostaci();
            
           }
        if($_POST['submit']=='Statystyki'){
            $statystyki= new Statystyki();
            echo $statystyki->statystykiform();
            if(isset($_POST['staty'])){
                $statystyki->statystykiwyswietl();
            }
        }
        elseif($_POST['submit']=='Wejdź do sklepu'){
            $sklep=new Sklep($postac);
            echo $sklep->obsluga('kupno');
            echo $sklep->obsluga('sprzedaz');
            if(isset($_POST['submit'])){
                echo $sklep->transakcja($_POST['submit']);
            }
            
        }
        elseif($_POST['submit']=='Wybierz Ekwipunek'){
            $ekwipunek=new Ekwipunek($_SESSION['posatac'][0]['id'],$aktywne);
            echo $ekwipunek->showekwipunek();
            if($_POST['submit']=='wyposaz'){
                $wiedzmin=new wiedzmin();
                $bron=$ekwipunek->aktywnyekwipunek($_POST['idbroni']);
                echo $wiedzmin->aktywnyEkwipunek($bron);
            }
        }
        elseif($_POST['submit']=='Wybierz Przeciwnika'){
            if(isset($_POST['potwor']) || $_POST['submit']=="Wybierz akcje" ){
                $przeciwnik=$_POST['potwor'];           
                $potwor= new Postac\Potwor($przeciwnik);
                $tura = new Tura();
                $tura->dodajGracza($postac);
                $tura->dodajPrzeciwnika($potwor);
                $tura->losowanie();
            }else{echo $this->wyborprzeciwnika();}
        }
        if($_POST['submit']=="Wybierz akcje"){
            do {
                
                $akcja1=($_POST['akcja']);
                echo $akcja1;
                $akcja2=$tura->akcja2();
                echo $akcja2;
                $akcja3=$tura->akcja3();
                echo $akcja3;
                $losowanie=$tura->losowanie();
                echo $losowanie;
           
        } while ($tura->sprawdzCzyKoniec());
        }
        
        
    }
    public function wybor(){
      return  '<form action="index.php" method="POST"> 
               <input type="hidden" name="rejestracja" value="true"/>
               <input type="submit" vlaue="rejsetracja"> 
              </form>
        <form action="index.php" method="POST"> 
               <input type="hidden" name="logowanie" value="true"/>
               <input type="submit" vlaue="logowanie"> 
              </form>';
    }
    public function wyborakcji() {
       
        return  '<form action="index.php" method="POST>
               <input type="submit" vlaue="Wybierz Ekwipunek">
               <input type="submit" vlaue="Statystyki">
               <input type="submit" vlaue="Wybierz Przeciwnika"> 
               <input type="submit" vlaue="Wejdź do sklepu"> 
              </form>';
    }
    public function wyborprzeciwnika(){
         return  '<form action="index.php" method="POST>
                  <select name="potwor">
                    <option value="potwor1">Potwor1</option>
                    <option value="potwor2">Potwor2</option>
                    <option value="potwor3">Potwor3</option>
                    <option value="potwor4">Potwor4</option>
                    <option value="potwor5">Potwor5</option>
                    </select>
                    <input type="submit" value="Wybierz Przeciwnika">
              </form>';
    }
    
    
     
}

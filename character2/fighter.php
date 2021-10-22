<!DOCTYPE html>
<html>
<head>
<title>White Box RPG Fighter Character Generator</title>
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
	<meta charset="UTF-8">
	<meta name="description" content="White Box RPG Fighter Character Generator. Goblinoid Games.">
	<meta name="keywords" content="White Box RPG, Goblinoid Games,HTML5,CSS,JavaScript">
	<meta name="author" content="Mark Tasaka 2018">
		

	<link rel="stylesheet" type="text/css" href="css/wb_fighter.css">
    
    
    
    
</head>
<body>
    
    <!--PHP-->
    <?php
    
    include 'php/armour.php';
    include 'php/checks.php';
    include 'php/weapons.php';
    include 'php/gear.php';
    include 'php/coins.php';
    include 'php/classDetails.php';
    include 'php/clothing.php';
    include 'php/characterRace.php';
    include 'php/demiHumanLevelLimit.php';
    include 'php/movementRate.php';
    include 'php/thaco.php';
    include 'php/abilityScoreGen.php';
    include 'php/nameSelect.php';
    include 'php/gender.php';
    include 'php/hitPoints.php';
    
    
        if(isset($_POST["theCharacterName"]))
        {
            $characterName = $_POST["theCharacterName"];
    
        }
        if(isset($_POST["theGivenName"]))
        {
            $givenName = $_POST["theGivenName"];

        }

        if($givenName == '100')
        {
            $givenName = rand(0, 49);
        }
        else
        {
            $givenName = $givenName;
        }
        


        if(isset($_POST["theSurname"]))
        {
            $surname = $_POST["theSurname"];

        }

        if($surname == '100')
        {
            $surname = rand(0, 37);
        }
        else
        {
            $surname = $surname;
        }



        if(isset($_POST['theCheckBoxCustomName']) && $_POST['theCheckBoxCustomName'] == 1) 
        {
            $givenName = 200;
            $surname = 200;
            
        } 
        
        if(isset($_POST["theGender"]))
        {
            $gender = $_POST["theGender"];
        }

        $genderName = getGenderName($gender);
        $genderNameIdentifier = genderNameGeneration ($gender);

        $fullName = getName($givenName, $surname, $genderNameIdentifier);

                
        
        if(isset($_POST["thePlayerName"]))
        {
            $playerName = $_POST["thePlayerName"];
    
        }
    

        
        if(isset($_POST["theCharacterRace"]))
        {
            $characterRace = $_POST["theCharacterRace"];
        }
    
            
        if(isset($_POST["theAlignment"]))
        {
            $alignment = $_POST["theAlignment"];
        }
    
        if(isset($_POST["theLevel"]))
        {
            $level = $_POST["theLevel"];
        
        } 
    
            $level = levelLimit ($characterRace, $level);
    
    
        if(isset($_POST["theSavingThrows"]))
        {
            $saveThrowOption = $_POST["theSavingThrows"];
        
        } 
    
        
        if(isset($_POST["theAbilityScore"]))
        {
            $abilityScoreGen = $_POST["theAbilityScore"];
        
        } 
    
        
        $abilityScoreArray = array();
        
        for($i = 0; $i < 6; ++$i)
        {
            $abilityScore = rollAbilityScores ($abilityScoreGen);

            array_push($abilityScoreArray, $abilityScore);

        }       

        $strength = $abilityScoreArray[0];
        $dexterity = $abilityScoreArray[1];
        $constitution = $abilityScoreArray[2];
        $wisdom = $abilityScoreArray[3];
        $intelligence = $abilityScoreArray[4];
        $charisma = $abilityScoreArray[5];
        
        $strengthMod = getAbilityModifier($strength);
        $dexterityMod = getAbilityModifier($dexterity);
        $constitutionMod = getAbilityModifier($constitution);
        $wisdomMod = getAbilityModifier($wisdom);
        $intelligenceMod = getAbilityModifier($intelligence);
        $charismaMod = getAbilityModifier($charisma);
    
        $exNext = experienceNextLevel($level);

        $hitPoints = getHitPoints($level, $constitutionMod);

        $hitDice = getHitDiceAmount($level);
    

    
        if(isset($_POST["theArmour"]))
        {
            $armour = $_POST["theArmour"];
        }
    
        $armourName = getArmour($armour)[0];
        $armourDefense = getArmour($armour)[1];
        $armourWeight = getArmour($armour)[2];
    
    
        $totalAcDefense = $armourDefense;
        $totalArmourWeight =  $armourWeight;
    
        $armourDefense = removeZero($armourDefense);
        $armourWeight = removeZero($armourWeight);
    
    
        if(isset($_POST["theGold"]))
        {
            $coins = $_POST["theGold"];
        }
    
        $coinQuantity = getCoins($coins)[0];
        $coinType = getCoins($coins)[1];
        $coinQuantity2 = getCoins($coins)[2];
        $coinType2 = getCoins($coins)[3];
    
    
         
        $weaponArray = array();
        $weaponNames = array();
        $weaponDamage = array();
        $weaponWeight = array();

        //For Random Select weapon
        if(isset($_POST['thecheckBoxRandomWeaponsV2']) && $_POST['thecheckBoxRandomWeaponsV2'] == 1) 
        {
            $weaponArray = getRandomWeapons();

        }
        else
        {
            if(isset($_POST["theWeapons"]))
            {
                foreach($_POST["theWeapons"] as $weapon)
                {
                    array_push($weaponArray, $weapon);
                }
            }
        }

    
    /*
        if(isset($_POST["theWeapons"]))
        {
            foreach($_POST["theWeapons"] as $weapon)
            {
                array_push($weaponArray, $weapon);
            }
        }*/
    
    foreach($weaponArray as $select)
    {
        array_push($weaponNames, getWeapon($select)[0]);
    }
        
    foreach($weaponArray as $select)
    {
        array_push($weaponDamage, getWeapon($select)[1]);
    }
        
    $totalWeaponWeight = 0;
    
    foreach($weaponArray as $select)
    {
        array_push($weaponWeight, getWeapon($select)[2]);
        $totalWeaponWeight += getWeapon($select)[2];
    }
    
    

        $gearArray = array();
        $gearNames = array();
        $gearWeight = array();
    
        //For Random Select gear
        if(isset($_POST['theCheckBoxRandomGear']) && $_POST['theCheckBoxRandomGear'] == 1) 
        {
            $gearArray = getRandomGear();
    
            $weaponCount = count($weaponArray);
    
    
            for($i = 0; $i < $weaponCount; ++$i)
            {
    
                if($weaponArray[$i] == "14" || $weaponArray[$i] == "15" )
                {
                    array_push($gearArray, 33);
                }

                if($weaponArray[$i] == "16" || $weaponArray[$i] == "17" )
                {
                    array_push($gearArray, 35);
                }
    
                if($weaponArray[$i] == "18")
                {
                    array_push($gearArray, 36);
                }
    
            }
    
        }
        else
        {
            //For Manually select gear
            if(isset($_POST["theGear"]))
                {
                    foreach($_POST["theGear"] as $gear)
                    {
                        array_push($gearArray, $gear);
                    }
                }
    
        }
    
        foreach($gearArray as $select)
        {
            array_push($gearNames, getGear($select)[0]);
        }
        
        $totalGearWeightOnly = 0;
    
        foreach($gearArray as $select)
        {
            array_push($gearWeight, getGear($select)[1]);
            $totalGearWeightOnly += getGear($select)[1];
        }

    
    $totalGearWeight = 10;
    
    $totalWeaponArmourWeight = $totalArmourWeight + $totalWeaponWeight; 
    
    
    $totalWeightCarried = $totalWeaponArmourWeight + $coinQuantity + $coinQuantity2 + $totalGearWeight;
    
    $saveMatrix = savingThrowMatrix ($level);

    
    $characterRaceTraits = demiHumanTraits ($characterRace);
    
    $movementRate = moveRate ($totalWeightCarried, $characterRace);
    
    $thaco = thaco($level);
    
    $halflingBonus = missileBonusHalfling ($characterRace);
    
    $dwarfSaveMagic = dwarfSaveMod ($characterRace);
    
    ?>

    
	
<!-- JQuery -->
  <img id="character_sheet"/>
   <section>

       
   <span id="characterName">
           <?php
                echo $characterName;
           ?>
        </span>

                     
       <span id="characterName2">
           <?php
                echo $fullName;
           ?>
        </span>

       
   <span id="playerName">
           <?php
                echo $playerName;
           ?>
        </span>
       
        <span id="gender">
           <?php
           echo $genderName;
           ?>
       </span>
       
<span id="strength">
        <?php
            echo $strength;
            ?>
        </span>

        
        <span id="strengthMod">
        <?php
            $strengthMod = getModSign($strengthMod);
            echo $strengthMod;
            ?>
        </span>

		<span id="dexterity">
        <?php
            echo $dexterity;
            ?>
        </span>

          <span id="dexterityMod">
        <?php
            $dexterityMod = getModSign($dexterityMod);
            echo $dexterityMod;
            ?>
        </span>

           
		<span id="constitution">
        <?php
            echo $constitution;
            ?>
        </span>

          <span id="constitutionMod">
        <?php
            $constitutionMod = getModSign($constitutionMod);
            echo $constitutionMod;
            ?>
        </span>

		<span id="wisdom">
        <?php
            echo $wisdom;
            ?>
        </span>

         <span id="wisdomMod">
        <?php
            $wisdomMod = getModSign($wisdomMod);
            echo $wisdomMod;
            ?>
        </span>

		<span id="intelligence">
        <?php
            echo $intelligence;
            ?>
        </span>

         <span id="intelligenceMod">
        <?php
            $intelligenceMod = getModSign($intelligenceMod);
            echo $intelligenceMod;
            ?>
        </span>

		<span id="charisma">
        <?php
            echo $charisma;
            ?>
        </span>

         <span id="charismaMod">
        <?php
            $charismaMod = getModSign($charismaMod);
            echo $charismaMod;
            ?>
        </span>

       
       <span id="race">
           <?php
           echo $characterRace;
           ?>
       </span>
       
       <span id="dieRollMethod"></span>

       
       <span id="class">Fighter</span>
       
       
       
       <span id="exNextLevel">
           <?php
           echo $exNext;
           ?>
       
       </span>
       
       
       <span id="meleeAc0"></span>
       <span id="meleeAc1"></span>
       <span id="meleeAc2"></span>
       <span id="meleeAc3"></span>
       <span id="meleeAc4"></span>
       <span id="meleeAc5"></span>
       <span id="meleeAc6"></span>
       <span id="meleeAc7"></span>
       <span id="meleeAc8"></span>
       <span id="meleeAc9"></span>
       
       <span id="missileAttack"></span>
       
       
       <span id="fighterAbility"></span>
       

       <span id="descendingAc"></span> 
       <span id="ascendingAc"></span>
       
       <span id="addLanguages"></span>
       
       <span id="hitPoints">
           <?php
           echo $hitPoints;
           ?>
           </span>
       
       <span id="hitDie">
           <?php
           echo $hitDice;
           ?></span>
       
       <span id="singleSave">
           <?php
           
           if($saveThrowOption == 1)
           {
               echo singleSave ($level); 
           }
           else
           {
               echo "";
           }
           
           ?>
       </span>
       
       
              
       <span id="saveMatrix">
           <?php
           
           if($saveThrowOption == 1)
           {
               echo ""; 
           }
           else
           {
               echo $saveMatrix[0];
               echo "<br/>";
               echo $saveMatrix[1] - $dwarfSaveMagic;
               echo "<br/>";
               echo $saveMatrix[2];
               echo "<br/>";
               echo $saveMatrix[3];
               echo "<br/>";
               echo $saveMatrix[4] - $dwarfSaveMagic;
           }
           
           ?>
       </span>
       
              <span id="saveMatrixDes">
           <?php
           
           if($saveThrowOption == 1)
           {
               echo ""; 
           }
           else
           {
               echo "vs. Death/Poison";
               echo "<br/>";
               echo "vs. Wands/Rays";
               echo "<br/>";
               echo "vs. Paralyze/Stone";
               echo "<br/>";
               echo "vs. Dragon Breath";
               echo "<br/>";
               echo "vs. Spells/Staffs";
           }
           
           ?>
       </span>
       
        <span id="saveMatrixTitle">
           <?php
           
           if($saveThrowOption == 1)
           {
               echo ""; 
           }
           else
           {
               echo "Saving Throws";
           }
           
           ?>
       </span>
       
       <span id="level">
           <?php
                echo $level;
           ?>
        </span>
       

              
         <span id="alignment">
           <?php
                echo $alignment;
           ?>
        </span>

              
       <span id="armourName">
           <?php
                echo $armourName;
           ?>
        </span>
       
       <span id="exBonus"></span>
              

              
       <span id="totalArmourWeight">
            <?php
                echo "Total weapons/armour<br/>weight: " . $totalWeaponArmourWeight . " lbs";
            ?>
       </span>
       
       
                     
       <span id="gearWeight">
            <?php
                echo "Total gear weight: " . $totalGearWeight . " lbs";
            ?>
       </span>
       
       
       <span id="weaponsList">
           <?php
           $val1 = 0;
           $val2 = 0;
           $val3 = 0;

           $count = count($weaponNames);
           
           foreach($weaponNames as $theWeapon)
           {
               echo $theWeapon;
               if($count > 2)
               {
                echo ", ";
               }
               else if($count === 2)
               {
                echo " & ";
               }
               else
               {
                echo ".";
               }


               --$count;
               $val1 = isWeaponTwoHanded($theWeapon, $val1);
               $val2 = isWeaponBastardSword($theWeapon, $val2);
           }
           
           $val3 = $val1 + $val2;
           
           $weaponNotes = weaponNotes($val3);
           
           ?>  
        </span>
       
       <span id="weaponNotes">
           <?php
                echo $weaponNotes;
           ?>
        </span>
            
       <span id="weaponsList2">
           <?php
           foreach($weaponDamage as $theWeaponDam)
           {
               echo $theWeaponDam;
               echo "<br/>";
           }
           ?>        
        </span>
       

       <span id="gearList">
           <?php
           
            $count = count($gearNames);
                    
            foreach($gearNames as $theGear)
            {
                echo $theGear;
                if($count > 2)
                {
                echo ", ";
                }
                else if($count === 2)
                {
                echo " & ";
                }
                else
                {
                echo ".";
                }

                --$count;

            }
           
           ?>
       </span>
           


       
       <span id="totalWeightCarried">
           <?php
           echo "Weight carried: " . $totalWeightCarried . " lbs / Movement Rate: " . $movementRate;
           ?>
       </span>
              
       
       <span id="wealth">
           <?php
           
           if($coinQuantity === 0)
           {
               echo "";
           }
           else
           {
           echo ($coinQuantity * 10) . $coinType;
           echo "<br/>";
           echo ($coinQuantity2 * 10) . $coinType2;
               
           }
           ?>
       </span>
       
       <span id="coinWeight">
           <?php
               
           if($coinQuantity === 0)
           {
               echo "";
           }
           else
           {
                echo "Coin weight: " . ($coinQuantity+$coinQuantity2) . " lbs";
           }
           ?>
       </span>
       

       
       <span id="characterRaceTrait">
           <?php
           echo $characterRaceTraits;
           ?>
       </span>
       
       <span id="hirelings"></span>
       
       <span id="abilityScoreGeneration">
            <?php
         //  echo $generationMessage;
           ?>
       </span>
       

       
	</section>
	

		
  <script>
  

  
       let imgData = "images/fighter_character_sheet.png";
      
        $("#character_sheet").attr("src", imgData);
      

	 
  </script>
		
	
    
</body>
</html>
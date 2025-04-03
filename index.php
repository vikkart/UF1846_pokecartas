<?php


function getPokemonData($pokerandom)
{
    // 2) lee el contenido de la api 
    $pokecontenido = file_get_contents("https://pokeapi.co/api/v2/pokemon/$pokerandom");
    // 3) lo decodifica
    $pokedata = json_decode($pokecontenido, true);
    // 4) Creo un objeto pokemon (me quedo sólo con los datos que necesito):
    // nombre (name)
    // imagen (sprites[front_default])
    // tipos (types[]-> dentro de cada elemento [type][name])
    $tipos = [];
    foreach ($pokedata['types'] as $value) {
        array_push($tipos, $value['type']['name']);
    }
    $habilidades = [];
    foreach ($pokedata['abilities'] as $value) {
        array_push($habilidades, $value["ability"]["name"]);
    }
    $pokemon = [
        'nombre' => $pokedata['name'],
        'foto' => $pokedata['sprites']['front_default'],
        'PokeId' => $pokedata["id"],
        'PokeTipos'=> $tipos, 
        'tipos'=> $tipos,
        'habilidades' => $habilidades
    ];
    return $pokemon;
}
function renderCards(){
    // 1) genera número aleatorio
    
    echo "<section id='pokcartase' class='allpokemons'>";
    $pokerandom = [rand(1, 151), rand(1, 151), rand(1, 151), rand(1, 151)]; 
    foreach ($pokerandom as $singlepokemon){ 
        $pokemon= getPokemonData($singlepokemon);
    // recibe datos y genera el html
    //var_dump($pokemon);
    $tiposClase = implode(' ', $pokemon['PokeTipos']);
        echo "    <div class='carta $tiposClase'>";
        echo "    <div class='nombre'>        <h3>{$pokemon['nombre']}</h3> </div>";
        echo "        <div class='img-container'>";
        echo "            <img src='{$pokemon['foto']}' alt='{$pokemon['nombre']}'>";
        echo "        </div>";
        echo "        <div class='datos'>";
        echo "            <div class='tipos-pokemon'>";
        foreach ($pokemon['PokeTipos'] as $tipo) {
            echo "                <span>$tipo</span>";
        }
        echo "            </div>";
        echo "            <ul class='habilidades'>";
        foreach ($pokemon['habilidades'] as $habilidad) {
            echo "                 <li>$habilidad</li>";
        }
        echo "                <li>impactrueno</li>";
        echo "            </ul>";
        echo "         </div>";
        echo "    <div class='id'>";
        echo "        <p>{$pokemon['PokeId']}</p>";
        echo "    </div>";
    echo "    </div>";
    echo "";
}
echo "</section>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokeWeb</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>PokeCartas</h1>
    <?php renderCards(); 
    ?>
    <div class='divboton'>
    <input type="button" id='boton' value="Generar pokemon" onclick="location.reload();">
    </div>
</body>

</html>
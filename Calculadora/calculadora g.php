<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora PHP</title>
    <link rel="stylesheet" type="text/css" href="Calculadora.css">
</head>
<body>
        <?php

        session_start();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["num1"]) && isset($_POST["operacao"]) && isset($_POST["num2"])) {
            $num1 = filter_input(INPUT_POST, 'num1', FILTER_VALIDATE_INT);
            $num2 = filter_input(INPUT_POST, 'num2', FILTER_VALIDATE_INT);
            
        $num1 = $_POST["num1"];
        $operacao = $_POST["operacao"];
        $num2 = $_POST["num2"];

        switch ($operacao) {
            case '+':
                $resultado = $num1 + $num2;
                break;
            case '-':
                $resultado = $num1 - $num2;
                break;
            case '*':
                $resultado = $num1 * $num2;
                break;
            case '/':

                if ($num2 != 0) {
                        $resultado = $num1 / $num2;
                    } else {
                        $resultado = "Erro";
                    }
                    break;
            case '^':
                $resultado = pow($num1, $num2);
                break;
            case '!':
                $resultado = gmp_fact($num1);
                break;
            default:
                $resultado = "Operação inválida";
            }

        if (!isset($_SESSION["historico"])) {
                $_SESSION["historico"] = [];
            }
            array_push($_SESSION["historico"], "$num1 $operacao $num2 = $resultado");
            $_SESSION["visor"] = "$num1 $operacao $num2 = $resultado";
        } else {
            $resultado = "Valores inválidos";
        }
                 }
            
       
        // if (isset($_POST["salvar"])) {
        //     if (isset($_SESSION["visor"]) && !empty($_SESSION["visor"])) {
        //         $_SESSION["memoria"] = $_SESSION["visor"];
        //     }
        // }
            
        if (isset($_POST["pegar_valores"])) {
            if (isset($_SESSION["memoria"])) {
                $_SESSION["visor"] = $_SESSION["memoria"];
                unset($_SESSION["memoria"]);
            }
        }
            
        if (isset($_POST["memoria"])) {
            if (isset($_SESSION["visor"]) && !empty($_SESSION["visor"])) {
                $_SESSION["memoria"] = $_SESSION["visor"];
            }
        }
            
        if (isset($_POST["limpar_h"])) {
            unset($_SESSION["historico"]);
            unset($_SESSION["visor"]);
        }
        
        
        ?>
    <div class="container">
        <h1 >Calculadora PHP</h1>
        <form method="post">
            <div class="campo">
                <label for="num1">Num_1</label>
                <input class="botao" type="text" name="num1" placeholder="0">
            </div>

            
            <div class="campo">
                <label for="operacao">Operação</label>
                <select name="operacao" required>
                    <option value="+" selected>+</option>
                    <option value="-">-</option>
                    <option value="/">/</option>
                    <option value="*">*</option>
                    <option value="^">^</option>
                    <option value="!">n!</option>
                </select>
            </div>
                
                <div class="campo">
                <label for="num1">Num_2</label>
                    <input class="botao" type="text" name="num2" placeholder="0">
                </div>
        

        <div class="campobotoes">
            <input type="submit" name="calcular" value="Calcular">
        </div>

        </form>
        <div>
            <h2 class="text-light">Conta:</h2>
            <div>
                <?php
                if (isset($_SESSION["visor"])) {
                    echo $_SESSION["visor"];
                }
                ?>
            </div>
        </div>

        <div class="campobotoesbaixo">
            <form method="post" >
                <!-- <input type="submit" name="salvar" value="Salvar"> -->
                <input type="submit" name="pegar_valores" value="Pegar Valores">
                <input type="submit" name="memoria" value="M">
                <input type="submit" name="limpar_h" value="Apagar Histórico">
            </form>
        </div>


        <div>
            <h2 class="text-light">Histórico:</h2>
            <div class="text-light">
                <?php
                if (isset($_SESSION["historico"])) {
                    foreach ($_SESSION["historico"] as $op) {
                        echo $op . "<br>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

</body>
</html>
<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunicado Interno (CI)</title>
    <style>
        :root {
            --federal-blue: #03045e;
            --honolulu-blue: #0077b6;
            --pacific-cyan: #00b4d8;
            --non-photo-blue: #90e0ef;
            --light-cyan: #caf0f8;
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: var(--light-cyan);
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: var(--federal-blue);
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        select, button {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--honolulu-blue);
            border-radius: 4px;
            font-size: 16px;
        }
        
        button {
            background-color: var(--honolulu-blue);
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: var(--pacific-cyan);
        }
        
        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>COMUNICADO INTERNO (CI)</h1>
        <form action="relatorio.php" method="POST">
            <div class="form-group">
                <select name="idcontrato" required>
                    <option value="">Selecione o Contrato</option>
                    <?php
                    $query = "SELECT idcontrato, cliente FROM view_contratos 
                             WHERE ativo = 'Sim' 
                             GROUP BY idcontrato 
                             ORDER BY cliente";
                    $result = $conn->query($query);
                    
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['idcontrato'] . "'>" . 
                             $row['idcontrato'] . " - " . $row['cliente'] . 
                             "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit">Gerar Relatório</button>
        </form>
    </div>
</body>
</html>

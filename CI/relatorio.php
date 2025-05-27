<?php
require_once 'config.php';

if (!isset($_POST['idcontrato'])) {
    header('Location: index.php');
    exit;
}

$idcontrato = $conn->real_escape_string($_POST['idcontrato']);

// Buscar dados do contrato
$query_contrato = "SELECT * FROM view_contratos WHERE idcontrato = '$idcontrato' AND ativo = 'Sim' LIMIT 1";
$result_contrato = $conn->query($query_contrato);
$contrato = $result_contrato->fetch_assoc();

// Buscar efetivo previsto
$query_efetivo = "SELECT * FROM view_efetivo_previsto WHERE idcontrato = '$idcontrato'";
$result_efetivo = $conn->query($query_efetivo);

// Buscar insumos
$query_insumos = "SELECT * FROM view_rel_insumos_contratos WHERE idcontrato = '$idcontrato'";
$result_insumos = $conn->query($query_insumos);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório - CI</title>
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
			font-size: 11px; /* Define o tamanho da fonte para 11px */
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        h1, h2 {
            color: var(--federal-blue);
            text-align: center;
        }
        
        .section {
            margin: 5px 0;
            padding: 10px;
            border: 1px solid var(--honolulu-blue);
            border-radius: 4px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .info-item {
            padding: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
        }
        
        th, td {
            border: 1px solid var(--honolulu-blue);
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: var(--pacific-cyan);
            color: white;
        }
        
        tr:nth-child(even) {
            background-color: var(--light-cyan);
        }
        
        .buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 20px 0;
        }
        
        .btn {
            padding: 10px 20px;
            background-color: var(--honolulu-blue);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        
        .btn:hover {
            background-color: var(--pacific-cyan);
        }
        
        @media print {
            .buttons {
                display: none;
            }
            
            body {
                background-color: white;
            }
            
            .container {
                box-shadow: none;
            }
        }
        
        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="buttons">
            <button class="btn" onclick="window.print()">Imprimir</button>
            <a href="export_pdf.php?id=<?php echo $idcontrato; ?>" class="btn">Exportar PDF</a>
        </div>

        <h1>COMUNICADO INTERNO (CI)</h1>
        
        <div class="section">
            <h2>Identificação do Cliente</h2>
            <div class="info-grid">
                <div class="info-item">
                    <strong>Contrato Nr:</strong> <?php echo $contrato['idcontrato'] . ' - ' . $contrato['cliente']; ?>
                </div>
                <div class="info-item">
                    <strong>CNPJ:</strong> <?php echo $contrato['cnpj']; ?>
                </div>
                <div class="info-item">
                    <strong>Valor Contrato:</strong> R$ <?php echo number_format($contrato['valor'], 2, ',', '.'); ?>
                </div>
                <div class="info-item">
                    <strong>Contato:</strong> <?php echo $contrato['contato']; ?>
                </div>
                <div class="info-item">
                    <strong>Celular:</strong> <?php echo $contrato['telefone']; ?>
                </div>
                <div class="info-item">
                    <strong>Email:</strong> <?php echo $contrato['email']; ?>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Efetivo Contratado</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th style="text-align: center;">Quantidade</th>
                            <th>Cargo/Função</th>
                            <th style="text-align: right;">Salário</th>
                            <th style="text-align: center;">Ac Função</th>
                            <th>Escala</th>
                            <th>Período</th>
                            <th>Jornada</th>
                            <th>Intrajornada</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_quantidade = 0;
                        $total_salario = 0;
                        
                        while ($efetivo = $result_efetivo->fetch_assoc()): 
                            $total_quantidade += intval($efetivo['quantidade']);
                            $total_salario += floatval($efetivo['salario']);
                        ?>
                            <tr>
                                <td style="text-align: center;"><?php echo number_format(intval($efetivo['quantidade']), 0, ',', '.'); ?></td>
                                <td><?php echo $efetivo['cargo']; ?></td>
                                <td style="text-align: right;"><?php echo number_format(floatval($efetivo['salario']), 2, ',', '.'); ?></td>
                                <td style="text-align: center;"><?php echo $efetivo['ac_funcao']; ?></td>
                                <td><?php echo $efetivo['escala']; ?></td>
                                <td><?php echo $efetivo['periodo']; ?></td>
                                <td><?php echo $efetivo['jornada']; ?></td>
                                <td><?php echo $efetivo['intrajornada']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                        <tr style="background-color: #f0f0f0; font-weight: bold;">
                            <td style="text-align: center;"><?php echo number_format($total_quantidade, 0, ',', '.'); ?></td>
                            <td style="text-align: right;">TOTAL</td>
                            <td style="text-align: right;"><?php /* echo number_format($total_salario, 2, ',', '.'); */?></td>
                            <td style="text-align: center;">-</td>
                            <td colspan="4"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section">
            <h2>Insumos Utilizados</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th style="text-align: center;">Quantidade</th>
                            <th>Insumo</th>
                            <th style="text-align: right;">Valor Mensal</th>
                            <th style="text-align: right;">Total R$</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_qtde = 0;
                        $total_vr_mensal = 0;
                        $total_vr_total = 0;
                        
                        while ($insumo = $result_insumos->fetch_assoc()): 
                            $total_qtde += intval($insumo['qtde']);
                            $total_vr_mensal += floatval($insumo['Vr Mensal']);
                            $total_vr_total += floatval($insumo['Vr Total']);
                        ?>
                            <tr>
                                <td style="text-align: center;"><?php echo number_format(intval($insumo['qtde']), 0, ',', '.'); ?></td>
                                <td><?php echo $insumo['insumo']; ?></td>
                                <td style="text-align: right;"><?php echo number_format(floatval($insumo['Vr Mensal']), 2, ',', '.'); ?></td>
                                <td style="text-align: right;"><?php echo number_format(floatval($insumo['Vr Total']), 2, ',', '.'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                        <tr style="background-color: #f0f0f0; font-weight: bold;">
                            <td style="text-align: center;"><?php echo number_format($total_qtde, 0, ',', '.'); ?></td>
                            <td style="text-align: right;">TOTAL</td>
                            <td style="text-align: right;"><?php /*echo number_format($total_vr_mensal, 2, ',', '.'); */ ?></td>
                            <td style="text-align: right;"><?php echo number_format($total_vr_total, 2, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section">
            <h2>Observações</h2>
            <p><?php echo nl2br($contrato['observacoes'] ?? ''); ?></p>
        </div>
    </div>
</body>
</html>

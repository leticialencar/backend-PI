<?php
require __DIR__ . '/../../config/config.php';

$conn = Conexao::getConn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_funcionario'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];
    $cargo = $_POST['cargo'];
    $data_admissao = $_POST['data_admissao'];
    $salario = $_POST['salario'];

    $cep = $_POST['cep'];
    $rua = $_POST['endereco'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];

    $telefone = $_POST['telefone'];

    try {
        $stmtFuncionario = $conn->prepare("UPDATE FUNCIONARIO SET
            nome_funcionario = ?, cpf_funcionario = ?, rg_funcionario = ?,
            id_cargo = ?, data_admissao = ?, salario = ?
            WHERE id_funcionario = ?");
        $stmtFuncionario->execute([$nome, $cpf, $rg, $cargo, $data_admissao, $salario, $id]);

        $stmtEndereco = $conn->prepare("UPDATE endereco_funcionario SET
            cep_funcionario = ?, rua_funcionario = ?, numero_funcionario = ?,
            bairro_funcionario = ?, cidade_funcionario = ?
            WHERE id_funcionario = ?");
        $stmtEndereco->execute([$cep, $rua, $numero, $bairro, $cidade, $id]);

        $stmtTelefone = $conn->prepare("UPDATE telefone_funcionario SET
            num_telefone_funcionario = ?
            WHERE id_funcionario = ?");
        $stmtTelefone->execute([$telefone, $id]);

        echo "Funcionário atualizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao atualizar funcionário: " . $e->getMessage();
    }
}
?>

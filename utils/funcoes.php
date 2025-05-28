<?php

function formatarDataHoraPtBr($dataHora) {
  if (!$dataHora) return '';
  $data = DateTime::createFromFormat('Y-m-d H:i:s', $dataHora);
  return $data ? $data->format('d/m/Y H:i:s') : $dataHora;
}

function formatarTelefone($telefone) {
  // Exemplo de máscara simples
  return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
}

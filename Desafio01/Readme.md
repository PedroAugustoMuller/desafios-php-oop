
Desenvolva uma página que busque o tempo atual de uma cidade especifica conforme especificações abaixo:
Na página:\

1- Deve existir um campo responsável para informar a cidade.\

2- Deve existir um checkbox que, caso selecionado, deve abrir outro campo para colocar um endereço de \email e enviar o resultado para tal.\

3-O resultado da chamada da API também deve aparecer na página.\

No "servidor":\

1-A API para a busca do tempo será a https://openweathermap.org/, que necessita da criação de uma conta\ gratuita para fornecer a api key.\

2- Utilizar o composer e escolher alguma biblioteca para o envio de email.\

3-Criar classes separadas para executar as ações de chamada e tratamento de dados da API.\

4- As informações que devem ser enviadas por email e mostradas na página devem ser as seguintes: • \Temperatura\
• Umidade\
• Velocidade do vento\
• Sensação térmica\
• Descrição do tempo\

5-O resultado da API deve ser armazenado no banco de dados\
• Se uma cidade já tiver dados no banco, deve retornar estes dados ao invés de fazer uma consulta à API\
• Os dados devem ser atualizados a cada uma hora, ou seja, se os dados salvos no banco de dados forem \de mais de 1h atrás, devem ser consultados novamente na API.\
• Deve haver histórico de consultas, dados antigos não podem ser apagados do banco de dados.\
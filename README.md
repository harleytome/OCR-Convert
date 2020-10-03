Rotinas em PHP para conversão de imagens para arquivos texto usando Teseract.
Inicialmente o cliente disponibilizou todos arquivos em pdf que foram scanneados.
Necessário converter para jpg para depois para TXT usando OCR.
Uma vez os arquivos em formato TXT, seria criado uma rotina para ler o cabeçalho e
identificar palavras chaves padrão, criar um indice e manter um mapa afim de localizar
os processos apartir destas informações.
Eventualmente poderia ser transferido para um banco de dados.
No projeto, apenas 30% a 40% tiveram margens de acerto e informações possiveis de mapeamento
devido a problemas de ilegibilidade das informações fornecidas (scanner).
Dentro da margem de acerto, ainda alguns dados estavam imprecisos e incompletos necessitando
a revisão manual por parte do cliente.
Inicialmente seriam processados mais de 8.000 arquivos na primeira fase.

Os arquivos em PDF foram contratos de advocacia antigos e que por lei necessitavam
serem digitalizados.
Alguns problemas conhecidos :
- arquivos com muita sugeira durante o processo de scanner
- arquivos deslocados durante o processo de scanner
- informações ilegíveis confundem o tesseract
- volume grande de arquivos exigem muito processamento
- necessidade de revisão manual e validação final para cada arquivo gerado (txt)

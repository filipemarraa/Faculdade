public class GameLogic {
    private int nrJogadas;
    private int naviosRestantes;
    private boolean[][] board;

    public GameLogic() {
        this.nrJogadas = 0;
        this.naviosRestantes = 5; // Exemplo, precisa implementar a lógica de navios
        this.board = new boolean[8][8]; // Tabuleiro 8x8
        initializeBoard();
    }

    private void initializeBoard() {
        // Inicializar o tabuleiro com navios (exemplo simples)
        for (int i = 0; i < 5; i++) {
            board[i][i] = true;
        }
    }

    public void incrementJogadas() {
        this.nrJogadas++;
    }

    public int getNrJogadas() {
        return nrJogadas;
    }

    public int getNaviosRestantes() {
        return naviosRestantes;
    }

    public void processMove(String position) {
        incrementJogadas();
        int row = position.charAt(0) - 'a';
        int col = Character.getNumericValue(position.charAt(1)) - 1;
        if (board[row][col]) {
            naviosRestantes--;
            board[row][col] = false;
        }
    }
}

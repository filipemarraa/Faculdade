class Aluno extends Pessoa {
    private String curso;
    private String matricula;

    public Aluno(String nome, String curso, String matricula) {
        super(nome);
        this.curso = curso;
        this.matricula = matricula;
    }

    public String getCurso() {
        return curso;
    }

    public String getMatricula() {
        return matricula;
    }
}

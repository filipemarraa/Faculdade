class Disciplina {
    private String nome;
    private Curso curso;
    private Professor professor;

    public Disciplina(String nome, Curso curso, Professor professor) {
        this.nome = nome;
        this.curso = curso;
        this.professor = professor;
    }

    public String getNome() {
        return nome;
    }

    public Curso getCurso() {
        return curso;
    }

    public Professor getProfessor() {
        return professor;
    }
}

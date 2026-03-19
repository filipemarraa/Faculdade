class Turma {
    private Professor professor;
    private Disciplina disciplina;
    private Set<Aluno> alunos;

    public Turma(Professor professor, Disciplina disciplina) {
        this.professor = professor;
        this.disciplina = disciplina;
        this.alunos = new HashSet<>();
    }

    public Professor getProfessor() {
        return professor;
    }

    public Disciplina getDisciplina() {
        return disciplina;
    }

    public Set<Aluno> getAlunos() {
        return alunos;
    }

    public void matricularAluno(Aluno aluno) {
        alunos.add(aluno);
    }
}

class Curso {
    private String nome;
    private Set<Disciplina> disciplinas;

    public Curso(String nome) {
        this.nome = nome;
        this.disciplinas = new HashSet<>();
    }

    public String getNome() {
        return nome;
    }

    public void adicionarDisciplina(Disciplina disciplina) {
        disciplinas.add(disciplina);
    }

    public Set<Disciplina> getDisciplinas() {
        return disciplinas;
    }
}

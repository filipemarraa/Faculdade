class Ensalamento {
    public void ensalarTurmas() {


        vincularDisciplinas(disciplinas, cursos, professores);


        criarTurmasEMatricularAlunos(alunos, disciplinas);


        imprimirTurmas(disciplinas);
    }

    private void vincularDisciplinas(List<Disciplina> disciplinas, List<Curso> cursos, List<Professor> professores) {

        for (Disciplina disciplina : disciplinas) {
            String disciplinaCurso = disciplina.getCurso().getNome();
            String professorDisciplina = disciplina.getProfessor().getNome();


            Curso cursoEncontrado = null;
            for (Curso curso : cursos) {
                if (curso.getNome().equals(disciplinaCurso)) {
                    cursoEncontrado = curso;
                    break;
                }
            }

            Professor professorEncontrado = null;
            for (Professor professor : professores) {
                if (professor.getNome().equals(professorDisciplina)) {
                    professorEncontrado = professor;
                    break;
                }
            }

            if (cursoEncontrado != null && professorEncontrado != null) {
                disciplina.setCurso(cursoEncontrado);
                disciplina.setProfessor(professorEncontrado);
                cursoEncontrado.adicionarDisciplina(disciplina);
            } else {
                System.out.println("Aviso: Disciplina '" + disciplina.getNome() + "' não vinculada a curso ou professor.");
            }
        }
    }

    private void criarTurmasEMatricularAlunos(List<Aluno> alunos, List<Disciplina> disciplinas) {
        for (Disciplina disciplina : disciplinas) {
            Curso curso = disciplina.getCurso();
            Professor professor = disciplina.getProfessor();


            Turma turma = new Turma(professor, disciplina);

            for (Aluno aluno : alunos) {
                if (aluno.getCurso().equals(curso.getNome()) && !estaMatriculadoEmDisciplina(aluno, disciplina)) {
                    turma.matricularAluno(aluno);
                }
            }
        }
    }

    private boolean estaMatriculadoEmDisciplina(Aluno aluno, Disciplina disciplina) {
        for (Turma turma : disciplina.getCurso().getDisciplinas()) {
            if (turma.getAlunos().contains(aluno)) {
                return true;
            }
        }
        return false;
    }

    private void imprimirTurmas(List<Disciplina> disciplinas) {
        for (Disciplina disciplina : disciplinas) {
            Turma turma = new Turma(disciplina.getProfessor(), disciplina);
            System.out.println("Turma: " + disciplina.getNome() + " - Professor: " + disciplina.getProfessor().getNome());
            System.out.println("Alunos matriculados:");
            for (Aluno aluno : turma.getAlunos()) {
                System.out.println("  - " + aluno.getNome());
            }
            System.out.println();
        }
    }
}

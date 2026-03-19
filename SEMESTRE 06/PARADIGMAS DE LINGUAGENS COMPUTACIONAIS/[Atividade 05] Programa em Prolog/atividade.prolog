% Definição de fatos
% estudante(Nome, Disciplina, Nota).
estudante(ana, matematica, 9).
estudante(ana, historia, 7).
estudante(ana, biologia, 8).
estudante(bruno, matematica, 6).
estudante(bruno, historia, 5).
estudante(bruno, fisica, 7).
estudante(carla, quimica, 10).
estudante(carla, matematica, 9).
estudante(carla, fisica, 8).
estudante(daniel, quimica, 4).
estudante(daniel, fisica, 3).
estudante(daniel, historia, 6).

% Regras para calcular a média das notas de um estudante
soma_notas_estudante(Nome, Soma, Total) :-
    findall(Nota, estudante(Nome, _, Nota), Notas),
    soma_lista(Notas, Soma),
    length(Notas, Total).

media_notas_estudante(Nome, Media) :-
    soma_notas_estudante(Nome, Soma, Total),
    Total > 0, % Evita divisão por zero
    Media is Soma / Total.

% Regras para listar estudantes de uma disciplina específica
estudantes_na_disciplina(Disciplina, Estudantes) :-
    findall(Nome, estudante(Nome, Disciplina, _), Estudantes).

% Regra para listar disciplinas de um estudante
disciplinas_do_estudante(Nome, Disciplinas) :-
    findall(Disciplina, estudante(Nome, Disciplina, _), Disciplinas).

% Função auxiliar para somar elementos de uma lista
soma_lista([], 0).
soma_lista([H|T], Soma) :-
    soma_lista(T, SomaRestante),
    Soma is H + SomaRestante.

% Regra para determinar o status de aprovação do estudante
status_aprovacao(Nome, Status) :-
    media_notas_estudante(Nome, Media),
    (   Media >= 7
    ->  Status = aprovado
    ;   Status = reprovado).

% Adição dinâmica de estudantes e notas
adicionar_estudante(Nome, Disciplina, Nota) :-
    assertz(estudante(Nome, Disciplina, Nota)).

% Remoção dinâmica de estudantes e notas
remover_estudante(Nome, Disciplina) :-
    retract(estudante(Nome, Disciplina, _)).

% Listagem de todos os estudantes
listar_todos_estudantes(Estudantes) :-
    findall(Nome, estudante(Nome, _, _), Lista),
    sort(Lista, Estudantes).

% Listagem de todas as disciplinas
listar_todas_disciplinas(Disciplinas) :-
    findall(Disciplina, estudante(_, Disciplina, _), Lista),
    sort(Lista, Disciplinas).

% Regra para verificar se um estudante está cadastrado
estudante_existe(Nome) :-
    estudante(Nome, _, _), !.
estudante_existe(Nome) :-
    \+ estudante(Nome, _, _),
    format("O estudante ~w não está cadastrado.~n", [Nome]), fail.

% Regra para verificar se uma disciplina está cadastrada
disciplina_existe(Disciplina) :-
    estudante(_, Disciplina, _), !.
disciplina_existe(Disciplina) :-
    \+ estudante(_, Disciplina, _),
    format("A disciplina ~w não possui estudantes cadastrados.~n", [Disciplina]), fail.

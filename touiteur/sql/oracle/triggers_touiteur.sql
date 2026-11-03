--Déclencheur 1 : Mise à jour du nombre de touites d’un utilisateur lors de la création d'un touite 

CREATE OR REPLACE TRIGGER trg_maj_nb_touites
AFTER INSERT ON Touite
FOR EACH ROW
BEGIN
    UPDATE Utilisateur
    SET nb_touites = nb_touites + 1
    WHERE id_utilisateur = :NEW.id_auteur;
END;

--Déclencheur 2 : Interdiction de se suivre soi-même ou de suivre un utilisateur avec le même email 


CREATE OR REPLACE TRIGGER trg_verif_suivi
BEFORE INSERT OR UPDATE ON Suivi_Utilisateur
FOR EACH ROW

DECLARE
    v_email_suiveur VARCHAR2(255);
    v_email_suivi VARCHAR2(255);

BEGIN
    -- Regle 1 : interdiction de se suivre soi-meme
    IF :NEW.id_suiveur = :NEW.id_suivi THEN
        RAISE_APPLICATION_ERROR(
            -20001,
            'Un utilisateur ne peut pas se suivre lui-meme.'
        );
    END IF;

    -- Recuperation de l'email du suiveur
    SELECT email INTO v_email_suiveur
    FROM Utilisateur
    WHERE id_utilisateur = :NEW.id_suiveur;

    -- Recuperation de l'email de l'utilisateur suivi
    SELECT email INTO v_email_suivi
    FROM Utilisateur
    WHERE id_utilisateur = :NEW.id_suivi;

    -- Regle 2 : interdiction de suivre un meme email
    IF v_email_suiveur = v_email_suivi THEN
        RAISE_APPLICATION_ERROR(
            -20002,
            'Impossible de suivre un utilisateur ayant le meme email.'
        );
    END IF;
END;

--Déclencheur 3 : Empêcher la modification de l'auteur d'un touite


CREATE OR REPLACE TRIGGER trg_bloquer_modif_auteur
BEFORE UPDATE OF id_auteur ON Touite
FOR EACH ROW
BEGIN
    IF :OLD.id_auteur != :NEW.id_auteur THEN
        RAISE_APPLICATION_ERROR(
            -20003,
            'Une fois publie, un touite conserve son auteur initial.'
        );
    END IF;
END;

--Déclencheur 4 : Limite de 50 touites par jour par utilisateur 

CREATE OR REPLACE TRIGGER trg_limite_touites_jour
FOR INSERT ON Touite
COMPOUND TRIGGER

    TYPE t_auteurs IS TABLE OF NUMBER INDEX BY PLS_INTEGER;
    TYPE t_dates IS TABLE OF DATE INDEX BY PLS_INTEGER;

    v_auteurs t_auteurs;
    v_dates t_dates;
    v_nb PLS_INTEGER := 0;

    -- Memoriser chaque touite insere
    BEFORE EACH ROW IS
    BEGIN
        v_nb := v_nb + 1;
        v_auteurs(v_nb) := :NEW.id_auteur;
        v_dates(v_nb) := TRUNC(
            NVL(:NEW.date_publication, SYSDATE)
        );
    END BEFORE EACH ROW;

    -- Verifier les limites apres l'insertion
    AFTER STATEMENT IS
        v_nb_touites_jour NUMBER;
    BEGIN
        FOR i IN 1..v_nb LOOP

            SELECT COUNT(*)
            INTO v_nb_touites_jour
            FROM Touite
            WHERE id_auteur = v_auteurs(i)
              AND TRUNC(date_publication) = v_dates(i);

            IF v_nb_touites_jour > 50 THEN
                RAISE_APPLICATION_ERROR(
                    -20004,
                    'Limite atteinte : 50 touites par jour maximum.'
                );
            END IF;

        END LOOP;
    END AFTER STATEMENT;

END trg_limite_touites_jour;

-- Korábbi választási eredmények (2022)
SELECT 
    E.nev AS 'Induló neve',
    M.nev AS 'Megye',
    P.nev AS 'Induló pártja',
    O.nev AS 'Országos lista',
    V.szavazat AS 'Szavazatok száma',
    CASE
        WHEN V.szavazat = MAX(V.szavazat) OVER(PARTITION BY V.valasztokerulet_id) THEN 'Igen'
        ELSE 'Nem'
    END AS 'Nyert?'
FROM 
    Valasztasiadatok V
INNER JOIN 
    Egyeni E ON V.egyeni_id = E.id
INNER JOIN 
    Valasztasikerulet VK ON V.valasztokerulet_id = VK.id
INNER JOIN 
    Megye M ON VK.megye_id = M.id
INNER JOIN 
    Orszagoslistak O ON V.orszagoslista_id = O.id
INNER JOIN 
    Partok P ON E.tamogatott_part_ = P.id
WHERE 
    V.ev = 2022;

-- Korábbi választási eredmények (2018)
SELECT 
    E.nev AS 'Induló neve',
    M.nev AS 'Megye',
    P.nev AS 'Induló pártja',
    O.nev AS 'Országos lista',
    V.szavazat AS 'Szavazatok száma',
    CASE
        WHEN V.szavazat = MAX(V.szavazat) OVER(PARTITION BY V.valasztokerulet_id) THEN 'Igen'
        ELSE 'Nem'
    END AS 'Nyert?'
FROM 
    Valasztasiadatok V
INNER JOIN 
    Egyeni E ON V.egyeni_id = E.id
INNER JOIN 
    Valasztasikerulet VK ON V.valasztokerulet_id = VK.id
INNER JOIN 
    Megye M ON VK.megye_id = M.id
INNER JOIN 
    Orszagoslistak O ON V.orszagoslista_id = O.id
INNER JOIN 
    Partok P ON E.tamogatott_part_ = P.id
WHERE 
    V.ev = 2018;
-- Korábbi választási eredmények (2014)
SELECT 
    E.nev AS 'Induló neve',
    M.nev AS 'Megye',
    P.nev AS 'Induló pártja',
    O.nev AS 'Országos lista',
    V.szavazat AS 'Szavazatok száma',
    CASE
        WHEN V.szavazat = MAX(V.szavazat) OVER(PARTITION BY V.valasztokerulet_id) THEN 'Igen'
        ELSE 'Nem'
    END AS 'Nyert?'
FROM 
    Valasztasiadatok V
INNER JOIN 
    Egyeni E ON V.egyeni_id = E.id
INNER JOIN 
    Valasztasikerulet VK ON V.valasztokerulet_id = VK.id
INNER JOIN 
    Megye M ON VK.megye_id = M.id
INNER JOIN 
    Orszagoslistak O ON V.orszagoslista_id = O.id
INNER JOIN 
    Partok P ON E.tamogatott_part_ = P.id
WHERE 
    V.ev = 2014;

-- Utolsó választási eredmények (2022) 

WITH MaxSzavazat AS (
    SELECT 
        V.valasztokerulet_id,
        MAX(V.szavazat) AS max_szavazat
    FROM 
        Valasztasiadatok V
    INNER JOIN 
        Valasztasikerulet VK ON V.valasztokerulet_id = VK.id
    INNER JOIN 
        Megye M ON VK.megye_id = M.id
    WHERE 
        V.ev = 2022
        AND M.nev = 'Pest' -- ITT ÍRD ÁT HA MÁSIK MEGYÉT SZERETNÉL
    GROUP BY 
        V.valasztokerulet_id
)
SELECT 
    E.nev AS 'Induló neve',
    VK.nev AS 'Terület',
    P.nev AS 'Induló pártja',
    V.szavazat AS 'Szavazatot kapott',
    CASE
        WHEN V.szavazat = MS.max_szavazat THEN 'Nyert'
        ELSE 'Nem nyert'
    END AS 'Nyert?'
FROM 
    Valasztasiadatok V
INNER JOIN 
    Egyeni E ON V.egyeni_id = E.id
INNER JOIN 
    Valasztasikerulet VK ON V.valasztokerulet_id = VK.id
INNER JOIN 
    Partok P ON E.tamogatott_part_ = P.id
INNER JOIN 
    Megye M ON VK.megye_id = M.id
INNER JOIN 
    MaxSzavazat MS ON V.valasztokerulet_id = MS.valasztokerulet_id
WHERE 
    V.ev = 2022
    AND M.nev = 'Pest' -- ITT ÍRD ÁT HA MÁSIK MEGYÉT SZERETNÉL
ORDER BY 
    VK.nev, E.nev;

-- Párt neve, összes eddigi indulójával, db számban
SELECT 
    P.nev AS 'Párt neve',
    COUNT(E.id) AS 'Indulók száma'
FROM 
    Valasztasiadatok V
INNER JOIN 
    Egyeni E ON V.egyeni_id = E.id
INNER JOIN 
    Partok P ON E.tamogatott_part_ = P.id
WHERE 
    P.nev = 'MKKP'  -- ITT ÍRD ÁT HA MÁSIK PÁRTRA SZERETNÉD MEGNÉZNI AZ ÖSSZES EDDIGI INDULÓT
GROUP BY 
    P.nev;

-- Adott párt, évenként elért szavazata százalékosan
SELECT 
    V.ev AS 'Indulási évek',
    ROUND(SUM(V.szavazat) * 100.0 / (SELECT SUM(szavazat) FROM Valasztasiadatok), 2) AS 'Országos eredmény %-osan'
FROM 
    Valasztasiadatok V
INNER JOIN 
    Orszagoslistak O ON V.orszagoslista_id = O.id
INNER JOIN 
    Partok P ON O.tamogatott_part = P.id
WHERE
    P.nev = 'MKKP' --ITT ÍRD ÁT HA MÁSIK PÁRTOT SZERETNÉL
GROUP BY 
    V.ev
ORDER BY 
    V.ev;
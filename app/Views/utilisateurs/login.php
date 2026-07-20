<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --mv-navy-dark: #0b2e3d;
            --mv-teal: #14806f;
            --mv-yellow: #ffcc00;
            --mv-text-soft: #6b7785;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Roboto, -apple-system, sans-serif;
            background: linear-gradient(135deg, var(--mv-navy-dark) 0%, var(--mv-teal) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: absolute;
            width: 380px;
            height: 380px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
            top: -140px;
            left: -120px;
        }

        body::after {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            background: rgba(255, 204, 0, 0.08);
            border-radius: 50%;
            bottom: -100px;
            right: -80px;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: #fff;
            border-radius: 24px;
            padding: 40px 34px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.25);
            position: relative;
            z-index: 1;
        }

        .brand-badge {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: var(--mv-yellow);
            color: var(--mv-navy-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 18px;
        }

        .login-card h1 {
            font-size: 1.3rem;
            font-weight: 700;
            text-align: center;
            color: #1a2530;
            margin-bottom: 4px;
        }

        .login-card p.sub {
            text-align: center;
            color: var(--mv-text-soft);
            font-size: 0.85rem;
            margin-bottom: 28px;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--mv-text-soft);
            margin-bottom: 6px;
        }

        .input-group-text {
            background: #eef7f5;
            border: 1px solid #e3e7eb;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: var(--mv-teal);
        }

        .form-control {
            border-radius: 0 12px 12px 0;
            border: 1px solid #e3e7eb;
            padding: 12px 14px;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--mv-teal);
            box-shadow: 0 0 0 3px rgba(20, 128, 111, 0.12);
        }

        .btn-mvola {
            background: var(--mv-yellow);
            color: var(--mv-navy-dark);
            font-weight: 700;
            border: none;
            border-radius: 12px;
            padding: 13px;
            width: 100%;
            font-size: 0.95rem;
            margin-top: 8px;
        }

        .btn-mvola:hover {
            background: #f0b800;
            color: var(--mv-navy-dark);
        }

        #resultat {
            text-align: center;
            font-size: 0.85rem;
            min-height: 20px;
            margin-top: 14px;
            color: #d94747;
            font-weight: 600;
        }

        #resultat.success {
            color: var(--mv-teal);
        }
    </style>
</head>

<body>

    <div class="login-card">
        <div class="brand-badge"><i class="fa-solid fa-bolt"></i></div>
        <h1>Connexion MVola</h1>
        <p class="sub">Accédez à votre espace en toute sécurité</p>

        <form id="formLogin">
            <div class="mb-3">
                <label for="numero" class="form-label">Numéro</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Entrer votre numéro" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="motDePasse" class="form-label">Mot de passe</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" class="form-control" id="motDePasse" name="motDePasse" placeholder="Mot de passe" required>
                </div>
            </div>

            <button type="submit" class="btn-mvola">Valider</button>
        </form>

        <p id="resultat"></p>
    </div>

    <script>
        document.getElementById("formLogin").addEventListener("submit", function(e) {

            e.preventDefault();

            let formData = new FormData();

            formData.append(
                "numero",
                document.getElementById("numero").value
            );

            formData.append(
                "motDePasse",
                document.getElementById("motDePasse").value
            );

            const resultat = document.getElementById("resultat");
            resultat.className = '';
            resultat.textContent = 'Connexion en cours…';

            fetch("<?= base_url('login') ?>", {
                    method: "POST",
                    body: formData
                })

                .then(async response => {
                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'La connexion a échoué.');
                    }

                    return data;
                })

                .then(data => {

                    resultat.textContent = data.message;

                    if (data.status === "success") {
                        resultat.className = 'success';
                        window.location.href = "<?= base_url('/') ?>";
                    }
                })

                .catch(error => {
                    resultat.textContent = error.message;
                });
        });
    </script>

</body>

</html>
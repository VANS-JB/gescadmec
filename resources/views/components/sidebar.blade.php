<style>
    aside {
  width: 250px;
  background-color: #f0f9ff; /* Bleu très clair */
  height: 100vh;
  padding: 1.5rem;
  border-right: 1px solid #e5e7eb; /* Gris clair */
}

aside h2 {
  font-size: 1.125rem;
  font-weight: bold;
  color: #1d4ed8; /* Bleu foncé */
  margin-bottom: 1.5rem;
}

aside ul {
  list-style: none;
  padding: 0;
}

aside li {
  margin-bottom: 1rem;
}

aside a {
  display: block;
  color: #2563eb;
  font-weight: 500;
  text-decoration: none;
}

aside a:hover {
  color: #1d4ed8;
  text-decoration: underline;
}
</style>
<aside class="w-64 bg-white shadow h-screen p-4">
    <ul class="space-y-4">
        <li><a href="#" class="text-blue-600 font-semibold">Tableau de bord</a></li>
        <li><a href="{{ route('inscription.create') }}">Inscriptions</a></li>
        <li><a href="#">Paiements</a></li>
        <li><a href="#">Besoins</a></li>
    </ul>
</aside>
<div>
	<h1>Necesita renovar su dominio!</h1>
	<p>El dominio "{{ $purchasedDomain->domain_name }}" se vencerá en {{  $purchasedDomain->expiration_date_for_humans }} </p>
	<p>Nota: Debe contactar con su proveedor de dominio: {{ $purchasedDomain->domainProvider->company_name }}</p>
</div>
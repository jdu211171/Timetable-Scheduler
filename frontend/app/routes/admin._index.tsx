export function meta() {
	return [{ title: 'Dashboard' }, { description: 'Librarian dashboard' }]
}

export default function LibrarianDashboard() {
	return (
		<div className='space-y-6'>
			<div className='flex justify-between items-center'>
				<h2 className='text-3xl font-bold tracking-tight'>Dashboard</h2>
				<p className='text-sm text-muted-foreground'>Last updated: 12:00 PM</p>
			</div>
			<div className='grid gap-4 md:grid-cols-2 lg:grid-cols-4'></div>
		</div>
	)
}

import { Button } from '~/components/ui/button'
import { Link, NavLink } from '@remix-run/react'
import { Menu } from 'lucide-react'
import { useState } from 'react'
import {
	Sheet,
	SheetContent,
	SheetTitle,
	SheetTrigger,
} from '~/components/ui/sheet'
import { ToggleTheme } from '~/components/toggle-theme'
import { Footer } from '~/components/footer'

export function meta() {
	return [
		{ title: 'TimeTable Management System' },
		{
			description:
				'Efficient resource management system for schools and institutions.',
		},
	]
}

export default function Index() {
	const [isOpen, setIsOpen] = useState(false)

	return (
		<div className='min-h-screen bg-background flex flex-col w-full'>
			{/* Navigation Bar */}
			<header className='sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60'>
				<div className='w-full px-4 flex h-14 items-center justify-between'>
					<NavLink to='/' className='flex items-center space-x-2'>
						<span className='font-bold text-sm sm:text-base md:text-lg'>
							TimeTable Management System
						</span>
					</NavLink>
					<div className='flex items-center space-x-4'>
						<ToggleTheme />
						<Sheet open={isOpen} onOpenChange={setIsOpen}>
							<SheetTrigger asChild>
								<Button variant='ghost' size='icon' className='md:hidden'>
									<Menu className='h-5 w-5' />
									<SheetTitle className='sr-only'>Toggle menu</SheetTitle>
								</Button>
							</SheetTrigger>
							<SheetContent side='right' className='w-[240px] sm:w-[300px]'>
								<nav className='flex flex-col space-y-4 mt-6'>
									<Button
										asChild
										variant='outline'
										className='justify-start'
										onClick={() => setIsOpen(false)}
									>
										<NavLink to='/admin'>Login</NavLink>
									</Button>
								</nav>
							</SheetContent>
						</Sheet>
						<nav className='hidden md:flex items-center space-x-4'>
							<Button asChild variant='default'>
								<NavLink to='/admin'>Login</NavLink>
							</Button>
						</nav>
					</div>
				</div>
			</header>

			{/* Main Content */}
			<main className='flex-grow'>
				<div className='container mx-auto px-4 py-8 md:py-10'>
					{/* Hero Section */}
					<section className='mb-12'>
						<div className='flex flex-col items-center text-center gap-2'>
							<h1 className='text-2xl font-extrabold leading-tight tracking-tighter md:text-4xl'>
								Welcome to the TimeTable Management System
							</h1>
							<p className='max-w-[700px] text-sm md:text-lg text-muted-foreground'>
								Efficiently manage and access resources with our comprehensive
								system.
							</p>
						</div>
					</section>
				</div>
			</main>
			<Footer />
		</div>
	)
}

import * as React from 'react'
import { Command } from 'lucide-react'
import { NavUser } from '~/components/nav-user'
import {
	Sidebar,
	SidebarContent,
	SidebarFooter,
	SidebarGroup,
	SidebarGroupContent,
	SidebarHeader,
	SidebarMenu,
	SidebarMenuButton,
	SidebarMenuItem,
	useSidebar,
} from '~/components/ui/sidebar'
import type { User } from '~/types/auth'
import { navConfig } from '~/lib/nav-config'
import { Link } from '@remix-run/react'

interface AppSidebarProps extends React.ComponentProps<typeof Sidebar> {
	user: User
}

export function AppSidebar({ user, ...props }: AppSidebarProps) {
	// Note: I'm using state to show active item.
	// IRL you should use the url/router.
	const [activeItem, setActiveItem] = React.useState(navConfig[0])
	const { setOpen } = useSidebar()

	return (
		<Sidebar
			collapsible='icon'
			className='overflow-hidden [&>[data-sidebar=sidebar]]:flex-row'
			{...props}
		>
			{/* This is the first sidebar */}
			{/* We disable collapsible and adjust width to icon. */}
			{/* This will make the sidebar appear as icons. */}
			<Sidebar
				collapsible='none'
				className='!w-[calc(var(--sidebar-width-icon)_+_1px)] border-r bg-background'
			>
				<SidebarHeader>
					<SidebarMenu>
						<SidebarMenuItem>
							<SidebarMenuButton size='lg' asChild className='md:h-8 md:p-0'>
								<a href='/'>
									<div className='flex aspect-square size-8 items-center justify-center rounded-lg bg-sidebar-primary text-white'>
										<Command className='size-4' />
									</div>
									<div className='grid flex-1 text-left text-sm leading-tight'>
										<span className='truncate font-semibold'>Byte Synergy</span>
										<span className='truncate text-xs'>Inc.</span>
									</div>
								</a>
							</SidebarMenuButton>
						</SidebarMenuItem>
					</SidebarMenu>
				</SidebarHeader>
				<SidebarContent>
					<SidebarGroup>
						<SidebarGroupContent className='px-1.5 md:px-0'>
							<SidebarMenu>
								{navConfig.map(item => (
									<SidebarMenuItem key={item.title}>
										<SidebarMenuButton
											tooltip={{
												children: item.title,
												hidden: false,
											}}
											onClick={() => {
												setActiveItem(item)
												setOpen(true)
											}}
											isActive={activeItem.title === item.title}
											className='px-2.5 md:px-2'
										>
											<item.icon />
											<span>{item.title}</span>
										</SidebarMenuButton>
									</SidebarMenuItem>
								))}
							</SidebarMenu>
						</SidebarGroupContent>
					</SidebarGroup>
				</SidebarContent>
				<SidebarFooter>
					<NavUser user={user} />
				</SidebarFooter>
			</Sidebar>

			{/* This is the second sidebar */}
			{/* We disable collapsible and let it fill remaining space */}
			<Sidebar
				collapsible='none'
				className='hidden flex-1 md:flex bg-background'
			>
				<SidebarHeader className='flex gap-3.5 border-b h-12 items-center'>
					<div className='flex w-full items-center justify-start'>
						<div className='text-base font-medium text-foreground'>
							{activeItem.title}
						</div>
					</div>
				</SidebarHeader>
				<SidebarContent>
					<SidebarGroup className='px-0'>
						<SidebarGroupContent>
							{activeItem.items.map(item => (
								<Link
									to={item.url}
									key={item.url}
									className='flex flex-col items-start gap-2 whitespace-nowrap border-b p-4 text-sm leading-tight last:border-b-0 hover:bg-sidebar-accent hover:text-sidebar-accent-foreground'
								>
									<div className='flex w-full items-center gap-2'>
										<span>{item.title}</span>
									</div>
								</Link>
							))}
						</SidebarGroupContent>
					</SidebarGroup>
				</SidebarContent>
			</Sidebar>
		</Sidebar>
	)
}

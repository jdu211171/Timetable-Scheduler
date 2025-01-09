import * as React from 'react'
import { useMatches } from '@remix-run/react'
import {
	Breadcrumb,
	BreadcrumbItem,
	BreadcrumbLink,
	BreadcrumbList,
	BreadcrumbPage,
	BreadcrumbSeparator,
} from '~/components/ui/breadcrumb'
import { navConfig } from '~/lib/nav-config'

interface RouteMapItem {
	title: string
	path: string
}

const routeMap: Record<string, RouteMapItem> = {
	'routes/_auth.login': { title: 'Login', path: '/login' },
	'routes/_auth.logout': { title: 'Logout', path: '/logout' },
	'routes/admin': { title: 'Dashboard', path: '/admin' },
	'routes/admin.groups': { title: 'Groups', path: '/admin/groups' },
	'routes/admin.groups.create': {
		title: 'Create Group',
		path: '/admin/groups/create',
	},
	'routes/admin.groups.$id.edit': {
		title: 'Edit Group',
		path: '/admin/groups/:id/edit',
	},
	'routes/admin.groups.$id.delete': {
		title: 'Delete Group',
		path: '/admin/groups/:id/delete',
	},
	'routes/admin.teachers': { title: 'Teachers', path: '/admin/teachers' },
	'routes/admin.teachers.create': {
		title: 'Create Teacher',
		path: '/admin/teachers/create',
	},
	'routes/admin.teachers.$id.edit': {
		title: 'Edit Teacher',
		path: '/admin/teachers/:id/edit',
	},
	'routes/admin.teachers.$id.delete': {
		title: 'Delete Teacher',
		path: '/admin/teachers/:id/delete',
	},
	'routes/admin.students': { title: 'Students', path: '/admin/students' },
	'routes/admin.students.create': {
		title: 'Create Student',
		path: '/admin/students/create',
	},
	'routes/admin.students.$id.edit': {
		title: 'Edit Student',
		path: '/admin/students/:id/edit',
	},
	'routes/admin.students.$id.delete': {
		title: 'Delete Student',
		path: '/admin/students/:id/delete',
	},
	'routes/admin.rooms': { title: 'Rooms', path: '/admin/rooms' },
	'routes/admin.rooms.create': {
		title: 'Create Room',
		path: '/admin/rooms/create',
	},
	'routes/admin.rooms.$id.edit': {
		title: 'Edit Room',
		path: '/admin/rooms/:id/edit',
	},
	'routes/admin.rooms.$id.delete': {
		title: 'Delete Room',
		path: '/admin/rooms/:id/delete',
	},
	'routes/admin.lessons': { title: 'Lessons', path: '/admin/lessons' },
	'routes/admin.lessons.create': {
		title: 'Create Lesson',
		path: '/admin/lessons/create',
	},
	'routes/admin.lessons.$id.edit': {
		title: 'Edit Lesson',
		path: '/admin/lessons/:id/edit',
	},
	'routes/admin.lessons.$id.delete': {
		title: 'Delete Lesson',
		path: '/admin/lessons/:id/delete',
	},
	'routes/admin.timetables': { title: 'Timetables', path: '/admin/timetables' },
	'routes/admin.timetables.create': {
		title: 'Create Timetable',
		path: '/admin/timetables/create',
	},
	'routes/admin.timetables.$id.edit': {
		title: 'Edit Timetable',
		path: '/admin/timetables/:id/edit',
	},
	'routes/admin.timetables.$id.conflicts': {
		title: 'Timetable Conflicts',
		path: '/admin/timetables/:id/conflicts',
	},
	'routes/admin.resources': { title: 'Resources', path: '/admin/resources' },
	...navConfig.admin.reduce(
		(acc, section) => ({
			...acc,
			...section.items.reduce(
				(items, item) => ({
					...items,
					[`routes/${item.url.slice(1).replace(/\//g, '.')}`]: {
						title: item.title,
						path: item.url,
					},
				}),
				{}
			),
		}),
		{}
	),
}

export function DynamicBreadcrumb() {
	const matches = useMatches()

	const breadcrumbs = matches
		.filter(match => match.id !== 'root')
		.filter(match => !match.id.includes('._index'))
		.map(match => {
			const routeId = match.id.replace(/\$/g, '')
			if (routeId.includes('._index')) return null
			return {
				id: match.id,
				title: routeMap[routeId]?.title || routeId.split('/').pop() || '',
				path: routeMap[routeId]?.path || match.pathname,
			}
		})
		.filter(Boolean)

	if (breadcrumbs.length === 0) return null

	return (
		<Breadcrumb>
			<BreadcrumbList>
				{breadcrumbs.map((crumb, index) => {
					const isLast = index === breadcrumbs.length - 1
					return (
						<React.Fragment key={crumb?.path}>
							<BreadcrumbItem>
								{isLast ? (
									<BreadcrumbPage>{crumb?.title}</BreadcrumbPage>
								) : (
									<BreadcrumbLink href={crumb?.path}>
										{crumb?.title}
									</BreadcrumbLink>
								)}
							</BreadcrumbItem>
							{!isLast && <BreadcrumbSeparator />}
						</React.Fragment>
					)
				})}
			</BreadcrumbList>
		</Breadcrumb>
	)
}

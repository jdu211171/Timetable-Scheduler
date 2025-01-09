import { zodResolver } from '@hookform/resolvers/zod'
import { ActionFunctionArgs } from '@remix-run/node'
import {
	Form,
	json,
	Link,
	useActionData,
	useNavigate,
	useNavigation,
} from '@remix-run/react'
import { isAxiosError } from 'axios'
import { ArrowLeft } from 'lucide-react'
import { useForm } from 'react-hook-form'
import { Button } from '~/components/ui/button'
import {
	Card,
	CardContent,
	CardDescription,
	CardHeader,
	CardTitle,
} from '~/components/ui/card'
import { Input } from '~/components/ui/input'
import { Label } from '~/components/ui/label'
import { createUserSession } from '~/services/auth.server'
import { LoginFormData, loginSchema } from '~/types/auth'

export function meta() {
	return [{ title: 'Login' }, { description: 'Login to your account' }]
}

export async function action({ request }: ActionFunctionArgs) {
	const formData = await request.formData()
	const email = formData.get('email')
	const password = formData.get('password')

	if (!email || !password) {
		return json(
			{ error: 'Please enter your email and password' },
			{ status: 400 }
		)
	}

	try {
		// const response = await api.post<SessionData>('/login', {
		// 	email,
		// 	password,
		// })
		if (email !== 'admin' || password !== 'admin') {
			return json({ error: 'Invalid credentials' }, { status: 400 })
		}

		const response = {
			data: {
				token: 'token',
				user: {
					id: 1,
					email: 'admin@example.com',
					name: 'Admin User',
					role: 'admin',
				},
			},
		}

		const { token, user } = response.data
		return createUserSession(token, user)
	} catch (error) {
		if (isAxiosError(error)) {
			return json(
				{ error: error.response?.data?.message || 'Invalid credentials' },
				{ status: 400 }
			)
		}
		return json({ error: 'Login failed' }, { status: 500 })
	}
}

export default function LoginPage() {
	const actionData = useActionData() as { error?: string }
	const navigation = useNavigation()
	const navigate = useNavigate()
	const isSubmitting = navigation.state === 'submitting'
	const {
		register,
		formState: { errors },
	} = useForm<LoginFormData>({
		resolver: zodResolver(loginSchema),
		defaultValues: {
			email: '',
			password: '',
		},
	})
	return (
		<div className='relative flex h-screen w-full items-center justify-center px-4'>
			<Button
				variant='ghost'
				onClick={() => navigate('/')}
				className='absolute left-4 top-4'
			>
				<ArrowLeft className='mr-2 h-4 w-4' />
				Go Back
			</Button>
			<Card className='mx-auto max-w-sm'>
				<CardHeader>
					<CardTitle className='text-2xl'>Login</CardTitle>
					<CardDescription>
						Enter your email below to access your account
					</CardDescription>
					{actionData?.error && (
						<p className='text-sm font-medium text-red-500 dark:text-red-400'>
							{actionData.error}
						</p>
					)}
				</CardHeader>
				<CardContent>
					<Form method='post' className='grid gap-4'>
						<div className='grid gap-2'>
							<Label htmlFor='email'>Email</Label>
							<Input
								{...register('email')}
								required
								id='email'
								placeholder='Enter your email'
							/>
							{errors.email && (
								<p className='text-sm text-red-500'>{errors.email.message}</p>
							)}
						</div>
						<div className='grid gap-2'>
							<div className='flex items-center'>
								<Label htmlFor='password'>Password</Label>
								<Link to='#' className='ml-auto inline-block text-sm underline'>
									Forgot your password?
								</Link>
							</div>
							<Input
								{...register('password')}
								required
								id='password'
								type='password'
								placeholder='Enter password'
							/>
							{errors.password && (
								<p className='text-sm text-red-500'>
									{errors.password.message}
								</p>
							)}
						</div>
						<Button type='submit' className='w-full' disabled={isSubmitting}>
							{isSubmitting ? 'Logging in...' : 'Login'}
						</Button>
						<Button variant='outline' className='w-full'>
							Login with Google
						</Button>
						<div className='mt-4 text-center text-sm'>
							Don&apos;t have an account?{' '}
							<Link to='#' className='underline'>
								Sign up
							</Link>
						</div>
					</Form>
				</CardContent>
			</Card>
		</div>
	)
}

import { Form, Head } from '@inertiajs/react';
import { ArrowRight } from 'lucide-react';
import InputError from '@/components/input-error';
import PasswordInput from '@/components/password-input';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/login';

type Props = {
    status?: string;
};

export default function Login({ status }: Props) {
    return (
        <>
            <Head title="Log in" />

            <Form
                {...store.form()}
                resetOnSuccess={['password']}
                className="flex flex-col gap-6"
            >
                {({ processing, errors }) => (
                    <div className="grid gap-6">
                        <div className="grid gap-2">
                            <Label
                                htmlFor="email"
                                className="text-xs font-semibold tracking-[0.22em] text-stone-400 uppercase"
                            >
                                Email address
                            </Label>
                            <Input
                                id="email"
                                type="email"
                                name="email"
                                required
                                autoFocus
                                tabIndex={1}
                                autoComplete="email"
                                placeholder="email@example.com"
                                className="h-12 rounded-full border-white/15 bg-white/[0.06] px-5 text-stone-50 shadow-none placeholder:text-stone-500 focus-visible:border-[#e7c889]/70 focus-visible:ring-[#e7c889]/20"
                            />
                            <InputError
                                message={errors.email}
                                className="text-[#f3a6a6]"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label
                                htmlFor="password"
                                className="text-xs font-semibold tracking-[0.22em] text-stone-400 uppercase"
                            >
                                Password
                            </Label>
                            <PasswordInput
                                id="password"
                                name="password"
                                required
                                tabIndex={2}
                                autoComplete="current-password"
                                placeholder="Password"
                                className="h-12 rounded-full border-white/15 bg-white/[0.06] px-5 text-stone-50 shadow-none placeholder:text-stone-500 focus-visible:border-[#e7c889]/70 focus-visible:ring-[#e7c889]/20"
                            />
                            <InputError
                                message={errors.password}
                                className="text-[#f3a6a6]"
                            />
                        </div>

                        <div className="flex items-center space-x-3">
                            <Checkbox
                                id="remember"
                                name="remember"
                                tabIndex={3}
                                className="border-white/20 bg-white/[0.06] data-[state=checked]:border-[#e7c889] data-[state=checked]:bg-[#e7c889] data-[state=checked]:text-stone-950"
                            />
                            <Label
                                htmlFor="remember"
                                className="text-sm text-stone-300"
                            >
                                Remember this workstation
                            </Label>
                        </div>

                        <Button
                            type="submit"
                            className="group mt-2 h-12 w-full rounded-full bg-[#e7c889] text-stone-950 shadow-none transition hover:bg-[#f1dca3]"
                            tabIndex={4}
                            disabled={processing}
                            data-test="login-button"
                        >
                            {processing && <Spinner />}
                            Enter dashboard
                            <ArrowRight className="size-4 transition-transform group-hover:translate-x-1" />
                        </Button>
                    </div>
                )}
            </Form>

            {status && (
                <div className="mt-5 rounded-full border border-emerald-300/20 bg-emerald-300/10 px-4 py-2 text-center text-sm font-medium text-emerald-200">
                    {status}
                </div>
            )}
        </>
    );
}

Login.layout = {
    title: 'Enter the atelier',
    description:
        'Use your admin credentials to shape the Goan Perfume catalogue.',
};

<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\Skill;
use App\Repositories\CandidateRepository;
use Illuminate\Http\UploadedFile;

class CVGradingService
{
    public function __construct(
        private CVParsingService $cvParsingService,
        private CandidateRepository $candidateRepository
    ) {
    }

    public function processCVUpload(string $candidateId, UploadedFile $cvFile): array
    {

        $cvContent = $this->readFileContent($cvFile);
        
        if (!$cvContent) {
            return [
                'success' => false,
                'message' => 'Failed to read CV file',
                'error_code' => 'READ_ERROR',
            ];
        }

        $parsedData = $this->cvParsingService->parseCV($cvContent);

        $candidate = Candidate::find($candidateId);
        if (!$candidate) {
            return [
                'success' => false,
                'message' => 'Candidate not found',
                'error_code' => 'CANDIDATE_NOT_FOUND',
            ];
        }

        $candidate->update([
            'years_experience' => $parsedData['years_experience'],
        ]);

        $skillIds = array_column($parsedData['skills'], 'skill_id');
        $candidate->skills()->sync($skillIds);

        $cvPath = $cvFile->store('cvs/' . $candidateId, 'public');

        $grade = $this->calculateCVGrade($parsedData);
        
        return [
            'success' => true,
            'message' => 'CV processed successfully',
            'grade' => $grade,
            'grade_letter' => $this->getLetterGrade($grade),
            'skills_found' => count($parsedData['skills']),
            'extracted_skills' => $parsedData['skills'],
            'years_experience' => $parsedData['years_experience'],
            'education_level' => $parsedData['education_level'],
            'certifications' => $parsedData['certifications'],
            'cv_path' => $cvPath,
            'feedback' => $this->generateFeedback($parsedData, $grade),
        ];
    }

    private function calculateCVGrade(array $parsedData): float
    {
        $grade = 0;

        $skillCount = $parsedData['skill_count'] ?? 0;
        $skillScore = min(40, $skillCount * 5); 

        $yearsExp = $parsedData['years_experience'] ?? 0;
        $expScore = min(30, $yearsExp * 2); 

        $educationLevel = $parsedData['education_level'] ?? 'Not Specified';
        $eduScore = match ($educationLevel) {
            'Doctorate' => 20,
            'Masters' => 18,
            'Bachelor' => 15,
            'Associate' => 10,
            'High School' => 5,
            default => 0,
        };

        $certCount = count($parsedData['certifications'] ?? []);
        $certScore = min(10, $certCount * 3); 

        $grade = $skillScore + $expScore + $eduScore + $certScore;
        
        return min(100, $grade);
    }

    private function getLetterGrade(float $grade): string
    {
        return match (true) {
            $grade >= 90 => 'A',
            $grade >= 80 => 'B',
            $grade >= 70 => 'C',
            $grade >= 60 => 'D',
            default => 'F',
        };
    }

    private function generateFeedback(array $parsedData, float $grade): array
    {
        $feedback = [];

        if ($parsedData['skill_count'] < 3) {
            $feedback[] = '⚠️ Consider adding more technical skills to your CV.';
        } elseif ($parsedData['skill_count'] >= 8) {
            $feedback[] = '✅ Great! You have a diverse skill set.';
        }

        $yearsExp = $parsedData['years_experience'] ?? 0;
        if ($yearsExp == 0) {
            $feedback[] = '💡 Try highlighting your projects and internships.';
        } elseif ($yearsExp >= 10) {
            $feedback[] = '✅ Impressive experience level!';
        }

        if ($parsedData['education_level'] === 'Not Specified') {
            $feedback[] = '💡 Make sure to include your education section clearly.';
        }

        $certCount = count($parsedData['certifications'] ?? []);
        if ($certCount == 0) {
            $feedback[] = '💡 Add relevant certifications to boost your profile.';
        } elseif ($certCount >= 3) {
            $feedback[] = '✅ Your certifications strengthen your profile!';
        }

        if ($grade >= 80) {
            $feedback[] = '🎉 Your CV is well-rounded and competitive!';
        } elseif ($grade >= 60) {
            $feedback[] = '👍 Good start! Consider adding more details to strengthen your CV.';
        } else {
            $feedback[] = '📝 Add more skills, experience, and certifications to improve your profile.';
        }
        
        return $feedback;
    }

    private function readFileContent(UploadedFile $file): ?string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        
        if ($extension === 'txt') {
            return file_get_contents($file->getRealPath());
        } elseif ($extension === 'pdf') {

            return $this->extractPdfText($file->getRealPath());
        } elseif ($extension === 'docx') {
            return $this->extractDocxText($file->getRealPath());
        }
        
        return null;
    }

    private function extractDocxText(string $filePath): string
    {

        $zip = zip_open($filePath);
        if (!is_resource($zip)) {
            return '';
        }
        
        $text = '';
        while ($zip_entry = zip_read($zip)) {
            if (zip_entry_name($zip_entry) == "word/document.xml") {
                $xml = zip_entry_read($zip_entry);

                $text = preg_replace('/<[^>]*>/', ' ', $xml);
                $text = html_entity_decode($text);
                break;
            }
        }
        zip_close($zip);
        
        return trim($text);
    }

    private function extractPdfText(string $filePath): string
    {

        return 'PDF text extraction not yet implemented. Please use TXT format.';
    }

    public function getCVGradeSummary(string $candidateId): ?array
    {
        $candidate = Candidate::find($candidateId);
        if (!$candidate) {
            return null;
        }
        
        $skills = $candidate->skills()->pluck('name')->toArray();
        
        return [
            'candidate_id' => $candidateId,
            'name' => $candidate->name,
            'years_experience' => $candidate->years_experience,
            'skills_count' => count($skills),
            'skills' => $skills,
            'profile_completeness' => $this->calculateProfileCompleteness($candidate),
        ];
    }

    private function calculateProfileCompleteness(Candidate $candidate): int
    {
        $completeness = 0;
        
        if ($candidate->name) $completeness += 20;
        if ($candidate->email) $completeness += 20;
        if ($candidate->phone) $completeness += 20;
        if ($candidate->years_experience) $completeness += 20;
        if ($candidate->skills()->count() > 0) $completeness += 20;
        
        return min(100, $completeness);
    }
}
